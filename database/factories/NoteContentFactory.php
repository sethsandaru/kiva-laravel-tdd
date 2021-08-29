<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\NoteContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NoteContent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'note_id' => (Note::factory()->create())->id,
            'content' => $this->faker->realText,
        ];
    }
}
