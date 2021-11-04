<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wimando\Survey\Models\Entry;

class EntryFactory extends Factory
{
    protected $model = Entry::class;

    public function definition(): array
    {
        return [
            'survey_id' => $this->faker->unique()->randomNumber(),
        ];
    }
}
