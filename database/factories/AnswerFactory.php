<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wimando\Survey\Models\Answer;
use Wimando\Survey\Models\Question;

class AnswerFactory extends Factory
{

    protected $model = Answer::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->words(3, true),
            'question_id' => Question::factory()->create()->id,
        ];
    }
}
