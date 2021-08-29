<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('isUsersNote', $this->route('note'));
    }

    public function rules(): array
    {
        return [];
    }
}
