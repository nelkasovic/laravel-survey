<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wimando\Survey\Models\Option;
use Wimando\Survey\Models\Question;

class OptionFactory extends Factory
{
    protected $model = Option::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->words(3, true),
            'question_id' => Question::factory()->create()->id,
            'description' => $this->faker->text,
        ];
    }
}
