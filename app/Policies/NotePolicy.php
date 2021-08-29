<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;

class NotePolicy
{
    /**
     * Is this note belongs to the User??
     *
     * @param User $user
     * @param Note $note
     *
     * @return bool
     */
    public function isUsersNote(User $user, Note $note): bool
    {
        return $note->user_id === $user->id;
    }
}
