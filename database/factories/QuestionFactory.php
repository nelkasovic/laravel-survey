<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wimando\Survey\Models\Question;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->name,
            'description' => $this->faker->text,
        ];
    }
}
