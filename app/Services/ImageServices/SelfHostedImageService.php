<?php

namespace App\Services\ImageServices;

use App\Domains\ImageManageContract;
use App\Models\Image;
use Illuminate\Http\UploadedFile;

class SelfHostedImageService implements ImageManageContract
{
    public const NAME = 'self-hosted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function upload(UploadedFile $file): Image
    {
        // TODO: Implement upload() method.
    }

    public function delete(): bool
    {
        // TODO: Implement delete() method.
    }
}
