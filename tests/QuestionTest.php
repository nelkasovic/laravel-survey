<?php

namespace Wimando\Survey\Tests;

use Wimando\Survey\Facades\Factories\Models\QuestionFactory;
use Wimando\Survey\Models\Question;
use Wimando\Survey\Models\Survey;

class QuestionTest extends TestCase
{
    /** @test */
    public function testQuestionHasContent()
    {
        $question = Question::factory()->create(['content' => 'How many cats do you have?']);

        $this->assertEquals('How many cats do you have?', $question->content);
    }

    /** @test */
    public function testQuestionHasType()
    {
        $question = Question::factory()->create(['type' => 'radio']);

        $this->assertEquals('radio', $question->type);
    }

    /** @test */
    public function testQuestionHasKey()
    {

        $question = Question::factory()->create();
        $this->assertNotNull($question->key);
    }

    /** @test */
    public function testQuestionMayHaveRules()
    {
        $question = QuestionFactory::create([
            'content' => 'How many cats do you have?',
            'rules' => ['numeric', 'min:1'],
        ]);

        $this->assertCount(2, $question->rules);
    }

    /** @test */
    public function testQuestionMayHaveOptions()
    {
        $question = QuestionFactory::create([
            'content' => 'How many cats do you have?',
            'options' => ['One', 'Two', 'Three'],
        ]);

        $this->assertCount(3, $question->options);
    }

    /** @test */
    public function testQuestionAutomaticallyPersistTheSameSurveyIdAsTheParentSection()
    {
        $survey = Survey::factory()->create();

        $section = $survey->sections()->create(['name' => 'Basic Information']);

        $question = $section->questions()->create([
            'content' => 'How many cats do you have?',
        ]);

        $this->assertEquals($survey->id, $question->survey->id);
    }
}
