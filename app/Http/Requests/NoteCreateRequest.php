<?php

namespace App\Http\Requests;

use App\Models\User;

class NoteCreateRequest extends NoteIndexRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
        ];
    }
}
