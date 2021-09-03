<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImagesShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewImage', $this->route('image'));
    }

    public function rules(): array
    {
        return [];
    }
}
