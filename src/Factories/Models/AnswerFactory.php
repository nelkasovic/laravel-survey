<?php

namespace Wimando\Survey\Factories\Models;

use Illuminate\Support\Facades\App;
use Wimando\Survey\Models\Answer;

class AnswerFactory
{
    public function create(array $attributes = []): Answer
    {
        return App::make(Answer::class, ['attributes' => $attributes]);
    }
}
