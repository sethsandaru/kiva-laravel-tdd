<?php

namespace Tests\Quick\Models;

use App\Models\Image;
use App\Models\Note;
use App\Models\User;
use Tests\Quick\TestCase;

class UserTest extends TestCase
{
    public function testUserHasManyNotes()
    {
        $user = $this->createRelationMock(User::class, 'hasMany', Note::class, 'user_id');
        $this->assertRelation('hasMany', $user->notes());
    }

    public function testUserHasManyImages()
    {
        $user = $this->createRelationMock(User::class, 'hasMany', Image::class, 'user_id');
        $this->assertRelation('hasMany', $user->images());
    }
}
