<?php

namespace Tests\Unit\Policies;

use App\Models\Image;
use App\Models\User;
use Tests\TestCase;

class ImagePolicyTest extends TestCase
{
    public function testUserImageWillReturnTrue()
    {
        $user = User::factory()->create();
        $image = Image::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue(
            $user->can('viewImage', $image)
        );
    }

    public function testSomebodyElseNoteWillReturnFalse()
    {
        $user = User::factory()->create();
        $image = Image::factory()->create(); // somebody else img

        $this->assertFalse(
            $user->can('viewImage', $image)
        );
    }
}
