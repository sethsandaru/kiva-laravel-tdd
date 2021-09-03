<?php

namespace App\Policies;

use App\Models\Image;
use App\Models\User;

class ImagePolicy
{
    /**
     * Can user view the specific image
     *
     * @param User $user
     * @param Image $image
     *
     * @return bool
     */
    public function viewImage(User $user, Image $image): bool
    {
        return $user->id === $image->user_id;
    }
}
