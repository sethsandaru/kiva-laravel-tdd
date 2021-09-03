<?php

namespace Tests\Unit\Services\ImageServices;

use App\Services\ImageServices\ImgbbImageService;
use Tests\TestCase;

class ImgbbImageServiceTest extends TestCase
{
    private ImgbbImageService $service;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'imgbb.base_url' => 'fake',
            'imgbb.client_secret' => 'fake_secret',
        ]);
        $this->service = app(ImgbbImageService::class);
    }

    public function testGetServiceName()
    {
        $this->assertEquals(
            ImgbbImageService::NAME,
            $this->service->getName()
        );
    }
}
