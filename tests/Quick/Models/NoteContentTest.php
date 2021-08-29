<?php

namespace Tests\Quick\Models;

use App\Models\Note;
use App\Models\NoteContent;
use Tests\Quick\TestCase;

class NoteContentTest extends TestCase
{
    public function testNoteBelongsToUser()
    {
        $note = $this->createRelationMock(NoteContent::class, 'belongsTo', Note::class, 'note_id');
        $this->assertRelation('belongsTo', $note->note());
    }
}
