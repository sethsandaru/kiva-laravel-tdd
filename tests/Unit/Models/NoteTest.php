<?php

namespace Tests\Unit\Models;

use App\Models\Note;
use Tests\TestCase;

class NoteTest extends TestCase
{
    public function testCreateNewNoteShouldHaveUuid()
    {
        $note = Note::factory()->create();
        $this->assertNotEmpty($note->uuid);
    }

    public function testSearchNoteByUuid()
    {
        $note = Note::factory()->create();

        $foundNote = Note::findByUuid($note->uuid);

        $this->assertNotNull($foundNote);
        $this->assertTrue($note->is($foundNote));
    }
}
