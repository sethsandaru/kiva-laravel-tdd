<?php

namespace Tests\Quick\Models;

use App\Models\Image;
use App\Models\User;
use Tests\Quick\TestCase;

class ImageTest extends TestCase
{
    public function testNoteBelongsToUser()
    {
        $note = $this->createRelationMock(Image::class, 'belongsTo', User::class, 'user_id');
        $this->assertRelation('belongsTo', $note->user());
    }
}
