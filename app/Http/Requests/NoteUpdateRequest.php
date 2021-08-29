<?php

namespace App\Http\Requests;

class NoteUpdateRequest extends NoteShowRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
        ];
    }
}
