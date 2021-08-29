<?php

namespace Tests\Feature\Controllers;

use App\Models\Note;
use App\Models\NoteContent;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NoteControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function testIndexWillReturnsUsersNotes()
    {
        $note = Note::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $content = NoteContent::factory()->create([
            'note_id' => $note->id,
        ]);

        $this->json('GET', 'api/v1/notes')
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $note->uuid,
                'title' => $note->title,
                'content' => $content->content,
            ]);
    }

    public function testIndexEmptyNote()
    {
        $this->json('GET', 'api/v1/notes')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function testShowWillReturnNoteInstance()
    {
        $note = Note::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $content = NoteContent::factory()->create([
            'note_id' => $note->id,
        ]);

        $this->json('GET', 'api/v1/notes/' . $note->uuid)
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $note->uuid,
                'title' => $note->title,
                'content' => $content->content,
            ]);
    }

    public function testShowErrorBecauseUserAccessNoteNotBelongsToHim()
    {
        $note = Note::factory()->create();
        $content = NoteContent::factory()->create([
            'note_id' => $note->id,
        ]);

        $this->json('GET', 'api/v1/notes/' . $note->uuid)
            ->assertStatus(403);
    }

    public function testStoreWillCreateNewNote()
    {
        $this->json('POST', 'api/v1/notes', [
            'title' => $title = $this->faker->name,
            'content' => $content = $this->faker->text,
        ])
        ->assertOk()
        ->assertJsonFragment([
            'title' => $title,
            'content' => $content,
        ]);

        $this->assertDatabaseHas('notes', [
            'title' => $title,
        ]);
        $this->assertDatabaseHas('note_contents', [
            'content' => $content,
        ]);
    }

    public function testUpdateWillUpdateNote()
    {
        $note = Note::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $content = NoteContent::factory()->create([
            'note_id' => $note->id,
        ]);

        $this->json('PUT', 'api/v1/notes/' . $note->uuid, [
            'title' => 'new title',
            'content' => 'here is a new content of my note',
        ])
        ->assertOk()
        ->assertJsonFragment([
            'uuid' => $note->uuid,
            'title' => 'new title',
            'content' => 'here is a new content of my note',
        ]);

        $note->refresh();
        $this->assertEquals('new title', $note->title);

        $content->refresh();
        // because history
        $this->assertNotEquals('here is a new content of my note', $content->content);
    }

    public function testUpdateErrorBecauseUserAccessNoteNotBelongsToHim()
    {
        $note = Note::factory()->create();
        $content = NoteContent::factory()->create([
            'note_id' => $note->id,
        ]);

        $this->json('PUT', 'api/v1/notes/' . $note->uuid, [
            'title' => 'new title',
            'content' => 'here is a new content of my note',
        ])->assertStatus(403);
    }

    public function testDestroyWillSoftDeleteTheNote()
    {
        $note = Note::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $content = NoteContent::factory()->create([
            'note_id' => $note->id,
        ]);

        $this->json('DELETE', 'api/v1/notes/' . $note->uuid)
            ->assertOk();

        $this->assertSoftDeleted('notes', [
            'id' => $note->id,
        ]);
        $this->assertSoftDeleted('note_contents', [
            'note_id' => $note->id,
        ]);
    }
}
