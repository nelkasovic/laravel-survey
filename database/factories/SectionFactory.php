<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Wimando\Survey\Models\Section;

class SectionFactory extends Factory
{
    protected $model = Section::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(5),
            'description' => $this->faker->text,
        ];
    }
}
