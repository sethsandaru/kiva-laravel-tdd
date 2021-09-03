<?php

namespace Tests\Unit\Services\ImageServices;

use App\Models\Image;
use App\Models\User;
use App\Services\HttpKits\ApiClient;
use App\Services\ImageServices\ImgbbImageService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImgbbImageServiceTest extends TestCase
{
    private ImgbbImageService $service;
    private ApiClient $client;
    private User $user;
    private string $fixtures;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'imgbb.base_url' => 'fake',
            'imgbb.client_secret' => 'fake_secret',
        ]);
        $this->user = User::factory()->create();

        $this->client = $this->createMock(ApiClient::class);
        $this->app->offsetSet(ApiClient::class, $this->client);
        $this->fixtures = __DIR__ . '/__fixtures__';

        $this->service = app(ImgbbImageService::class);
    }

    public function testGetServiceName()
    {
        $this->assertEquals(
            ImgbbImageService::NAME,
            $this->service->getName()
        );
    }

    public function testUploadSuccessfully()
    {
        $imageFile = UploadedFile::fake()->image('my-image.jpg');

        // create mock api response
        $uploadSuccessfulResponse = $this->getSuccessfulMockedResponse($this->fixtures . '/upload_successful_response.json');
        $this->client->method('setContentType')->willReturnSelf();
        $this->client->method('post')->willReturn($uploadSuccessfulResponse);

        $image = $this->service->upload($imageFile, $this->user);

        $this->assertNotNull($image);
        $this->assertIsString($image->url);
        $this->assertIsString($image->filename);
        $this->assertIsArray($image->payload);

        $this->assertDatabaseHas($image->getTable(), [
            'uuid' => $image->uuid,
            'service' => ImgbbImageService::NAME,
        ]);
    }

    public function testUploadFailedFromExternal()
    {
        $imageFile = UploadedFile::fake()->image('my-image.jpg');

        // create mock api response
        $uploadResponse = $this->getErrorMockedResponse($this->fixtures . '/upload_failed_response.json');
        $this->client->method('post')->willReturn($uploadResponse);

        $image = $this->service->upload($imageFile, $this->user);

        $this->assertNull($image);
        $this->assertIsString($this->service->getErrorMessage());
    }

    public function testDeleteSuccessfully()
    {
        $image = Image::factory()->create();
        $this->service->delete(
            $image
        );

        $this->assertDatabaseMissing($image->getTable(), [
            'id' => $image->id,
        ]);
    }
}
