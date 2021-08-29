<?php

namespace App\Domains;

use App\Models\Image;
use Illuminate\Http\UploadedFile;

interface ImageManageContract
{
    /**
     * Get the service's name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Upload the file
     *
     * @param UploadedFile $file
     *
     * @return Image
     */
    public function upload(UploadedFile $file): Image;

    /**
     * Delete the file
     *
     * @return bool
     */
    public function delete(): bool;
}
