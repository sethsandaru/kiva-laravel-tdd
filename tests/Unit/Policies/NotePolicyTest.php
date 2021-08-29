<?php

namespace Tests\Unit\Policies;

use App\Models\Note;
use App\Models\User;
use Tests\TestCase;

class NotePolicyTest extends TestCase
{
    public function testUserNoteWillReturnTrue()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue(
            $user->can('isUsersNote', $note)
        );
    }

    public function testSomebodyElseNoteWillReturnFalse()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $note = Note::factory()->create([
            'user_id' => $user2->id,
        ]);

        $this->assertFalse(
            $user->can('isUsersNote', $note)
        );
    }
}
