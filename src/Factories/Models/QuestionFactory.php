<?php

namespace Wimando\Survey\Factories\Models;

use Illuminate\Support\Facades\App;
use Wimando\Survey\Models\Question;

class QuestionFactory
{
    public function create(array $attributes = []): Question
    {
        return App::make(Question::class, ['attributes' => $attributes]);
    }
}
