<?php

namespace App\Http\Requests;

use App\Domains\ImageManageContract;
use App\Services\ImageServices\ImgbbImageService;
use App\Services\ImageServices\SelfHostedImageService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class ImagesStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'image' => 'required|image|max:2048',
            'type' => [
                'required',
                'string',
                Rule::in([
                    SelfHostedImageService::NAME,
                    ImgbbImageService::NAME,
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Image is required',
            'image.image' => 'File must be an Image (jpg, png, gif)',
            'image.max' => 'File must not exceed 2MB',
            'type.required' => 'Service type is required',
            'type.in' => 'Service type is not supported.',
        ];
    }

    public function getImage(): UploadedFile
    {
        return $this->file('image');
    }

    public function getRequestedService(): ImageManageContract
    {
        return app()->makeWith(ImageManageContract::class, [
            'service' => $this->input('type'),
        ]);
    }
}
