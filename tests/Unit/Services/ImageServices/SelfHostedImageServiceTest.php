<?php

namespace Tests\Unit\Services\ImageServices;

use App\Models\User;
use App\Services\ImageServices\SelfHostedImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SelfHostedImageServiceTest extends TestCase
{
    private SelfHostedImageService $service;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(SelfHostedImageService::class);
        $this->user = User::factory()->create();
    }

    public function testGetServiceName()
    {
        $this->assertEquals(
            SelfHostedImageService::NAME,
            $this->service->getName()
        );
    }

    public function testUploadSuccessfully()
    {
        Storage::fake();
        $imageFile = UploadedFile::fake()->image('my-image.jpg');

        $image = $this->service->upload($imageFile, $this->user);

        $this->assertNotNull($image);
        $this->assertIsString($image->url);
        $this->assertIsString($image->filename);
        $this->assertIsArray($image->payload);

        $this->assertDatabaseHas($image->getTable(), [
            'uuid' => $image->uuid,
        ]);

        Storage::assertExists($image->payload['filePath']);
    }

    public function testDeleteSuccessfully()
    {
        Storage::fake();
        $imageFile = UploadedFile::fake()->image('my-image.jpg');
        $image = $this->service->upload($imageFile, $this->user);
        Storage::assertExists($image->payload['filePath']);

        $deleteStatus = $this->service->delete($image);

        $this->assertTrue($deleteStatus);
        $this->assertDatabaseMissing($image->getTable(), [
            'uuid' => $image->uuid,
        ]);
        Storage::assertMissing($image->payload['filePath']);
    }
}
