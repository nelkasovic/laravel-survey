<?php

namespace Wimando\Survey\Factories\Models;

use Illuminate\Support\Facades\App;
use Wimando\Survey\Models\Survey;

class SurveyFactory
{
    public function create(array $attributes = []): Survey
    {
        return App::make(Survey::class, ['attributes' => $attributes]);
    }
}
