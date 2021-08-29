<?php

namespace Tests\Quick\Models;

use App\Models\Note;
use App\Models\NoteContent;
use App\Models\User;
use Tests\Quick\TestCase;

class NoteTest extends TestCase
{
    public function testNoteBelongsToUser()
    {
        $note = $this->createRelationMock(Note::class, 'belongsTo', User::class, 'user_id');
        $this->assertRelation('belongsTo', $note->user());
    }

    public function testNoteHasManyContents()
    {
        $note = $this->createRelationMock(Note::class, 'hasMany', NoteContent::class, 'note_id');
        $this->assertRelation('hasMany', $note->contents());
    }
}
