<?php

namespace Wimando\Survey\Tests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Wimando\Survey\Models\Question;
use Wimando\Survey\Models\Survey;

class SurveyValidationTest extends TestCase
{
    /** @test */
    public function testSurveyCanBeValidated()
    {
        $survey = Survey::factory()->create();

        $survey->questions()->save(Question::factory()->create(['rules' => ['numeric']]));

        $validator = Validator::make(['q1' => 'Not a number'], $survey->rules);

        $this->expectException(ValidationException::class);

        $validator->validate();
    }
}
