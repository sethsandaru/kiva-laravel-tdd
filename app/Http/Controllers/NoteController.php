<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteCreateRequest;
use App\Http\Requests\NoteDeleteRequest;
use App\Http\Requests\NoteIndexRequest;
use App\Http\Requests\NoteShowRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\JsonResponse;

class NoteController extends APIController
{
    /**
     * Get a list of notes of User (Pagination applied)
     *
     * @param NoteIndexRequest $request
     *
     * @return JsonResponse
     */
    public function index(NoteIndexRequest $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $notes = Note::where('user_id', $request->user()->id)->paginate($limit);
        return $this->respondOk(NoteResource::collection($notes)->resource);
    }

    /**
     * Get single note
     *
     * @param Note $note
     * @param NoteShowRequest $request
     *
     * @return JsonResponse
     */
    public function show(Note $note, NoteShowRequest $request): JsonResponse
    {
        return $this->respondOk(new NoteResource($note));
    }

    /**
     * Create a new note
     *
     * @param NoteCreateRequest $request
     *
     * @return JsonResponse
     */
    public function store(NoteCreateRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        $note = Note::create($inputs + ['user_id' => $request->user()->id]);
        $note->contents()->create([
            'content' => $inputs['content'],
        ]);

        return $this->respondOk(new NoteResource($note));
    }

    /**
     * Update a note
     *
     * @param Note $note
     * @param NoteUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(Note $note, NoteUpdateRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        $note->update($inputs);
        $note->contents()->create([
            'content' => $inputs['content'],
        ]);

        return $this->respondOk((new NoteResource($note)));
    }

    /**
     * Delete a note
     *
     * @param Note $note
     * @param NoteDeleteRequest $request
     *
     * @return JsonResponse
     */
    public function destroy(Note $note, NoteDeleteRequest $request): JsonResponse
    {
        $note->delete();
        $note->contents()->delete();

        return $this->respondOk([]);
    }
}
