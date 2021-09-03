<?php

namespace Tests\Unit\Services\ImageServices;

use App\Services\ImageServices\SelfHostedImageService;
use Tests\TestCase;

class SelfHostedImageServiceTest extends TestCase
{
    private SelfHostedImageService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(SelfHostedImageService::class);
    }

    public function testGetServiceName()
    {
        $this->assertEquals(
            SelfHostedImageService::NAME,
            $this->service->getName()
        );
    }
}
