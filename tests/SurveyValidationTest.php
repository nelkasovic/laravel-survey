<?php

namespace Wimando\Survey\Tests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Wimando\Survey\Models\Question;
use Wimando\Survey\Models\Survey;

class SurveyValidationTest extends TestCase
{
    /** @test */
    public function it_can_be_validated()
    {
        $survey = create(Survey::class);

        $survey->questions()->save(make(Question::class, ['rules' => ['numeric']]));

        $validator = Validator::make(['q1' => 'Not a number'], $survey->rules);

        $this->expectException(ValidationException::class);

        $validator->validate();
    }
}
