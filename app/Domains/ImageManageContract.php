<?php

namespace App\Domains;

use App\Models\Image;
use App\Models\User;
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
     * @param User $user
     *
     * @return Image
     */
    public function upload(UploadedFile $file, User $user): ?Image;

    /**
     * Delete the file
     *
     * @param Image $image
     *
     * @return bool
     */
    public function delete(Image $image): bool;
}
