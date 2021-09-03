<?php

namespace Tests\Feature\Controllers;

use App\Domains\ImageManageContract;
use App\Models\Image;
use App\Models\User;
use App\Services\ImageServices\ImgbbImageService;
use App\Services\ImageServices\SelfHostedImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ImagesControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function testIndexWillReturnsUsersImages()
    {
        $image1 = Image::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $image2 = Image::factory()->create();

        $this->json('GET', 'api/v1/images')
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $image1->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $image2->uuid,
            ])
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'uuid',
                        'url',
                        'filename',
                        'service',
                    ],
                ],
            ]);
    }

    public function testShowWillReturnImageDetails()
    {
        $image = Image::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->json('GET', 'api/v1/images/' . $image->uuid)
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $image->uuid,
                'url' => $image->url,
                'filename' => $image->filename,
                'service' => $image->service,
            ]);
    }

    public function testStoreWillUploadImage()
    {
        $disk = Storage::fake('public');
        $imageFile = UploadedFile::fake()->image('my-image.jpg');

        $response = $this->json('POST', 'api/v1/images', [
            'type' => SelfHostedImageService::NAME,
            'image' => $imageFile,
        ]);

        $response->assertOk();

        $fileName = $response->json('filename');
        $disk->assertExists(SelfHostedImageService::BASE_PATH . '/' . $fileName);

        // mocking imgbb service and set DI
        $imgBBService = $this->createMock(ImgbbImageService::class);
        $imgBBService->expects($this->once())->method('upload')->willReturn(
            $image = Image::factory()->create()
        );
        $this->app->offsetSet(ImageManageContract::class, $imgBBService);

        $this->json('POST', 'api/v1/images', [
            'type' => ImgbbImageService::NAME,
            'image' => $imageFile,
        ])
        ->assertOk()
        ->assertJsonFragment([
            'uuid' => $image->uuid,
            'url' => $image->url,
            'filename' => $image->filename,
            'service' => $image->service,
        ]);
    }

    public function testStoreUploadFailedWillReturnError()
    {
        $imageFile = UploadedFile::fake()->image('my-image.jpg');

        // mocking imgbb service and set DI
        $imgBBService = $this->createMock(ImgbbImageService::class);
        $imgBBService->expects($this->once())->method('upload')->willReturn(null);
        $this->app->offsetSet(ImageManageContract::class, $imgBBService);

        $this->json('POST', 'api/v1/images', [
            'type' => ImgbbImageService::NAME,
            'image' => $imageFile,
        ])
        ->assertStatus(400)
        ->assertJsonStructure([
            'error',
        ]);
    }

    public function testStoreUploadGotValidationError()
    {
        $imageFile = UploadedFile::fake()->image('my-image.jpg');

        // missing img
        $this->json('POST', 'api/v1/images', [
            'type' => ImgbbImageService::NAME,
        ])->assertStatus(422)->assertInvalid(['image']);

        // wrong type
        $this->json('POST', 'api/v1/images', [
            'type' => 'fake',
            'image' => $imageFile,
        ])->assertStatus(422)->assertInvalid(['type']);
    }

    public function testDestroyWillRemoveTheImage()
    {
        $disk = Storage::fake(SelfHostedImageService::DISK);
        $imageFile = UploadedFile::fake()->image('my-image.jpg')
            ->storePubliclyAs('test', 'my-image.jpg', ['disk' => SelfHostedImageService::DISK]);

        $image = Image::factory()->create([
            'user_id' => $this->user->id,
            'payload' => [
                'filePath' => $imageFile,
            ],
        ]);

        $disk->assertExists($imageFile);

        $this->json('DELETE', 'api/v1/images/' . $image->uuid)
            ->assertOk();

        $disk->assertMissing($imageFile);
    }
}
