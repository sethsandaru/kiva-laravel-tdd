<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\User;
use App\Services\ImageServices\SelfHostedImageService;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => (User::factory()->create())->id,
            'service' => SelfHostedImageService::NAME,
            'filename' => $fileName = $this->faker->userName . '.' . $this->faker->fileExtension(),
            'url' => url('images/' . $fileName),
        ];
    }
}
