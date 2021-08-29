<?php

namespace App\Services\ImageServices;

use App\Domains\ImageManageContract;
use App\Models\Image;
use Illuminate\Http\UploadedFile;

class ImgurImageService implements ImageManageContract
{
    public const NAME = 'imgur';

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
