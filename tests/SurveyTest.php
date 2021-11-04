<?php

namespace Wimando\Survey\Tests;

use Wimando\Survey\Facades\Factories\Models\SurveyFactory;
use Wimando\Survey\Models\Question;
use Wimando\Survey\Models\Survey;

class SurveyTest extends TestCase
{
    /** @test */
    public function testSurveyHasName()
    {
        $survey = Survey::factory()->create(['name' => 'Cat Survey']);

        $this->assertEquals('Cat Survey', $survey->name);
    }

    /** @test */
    public function testSurveyHasSettings()
    {
        $survey = SurveyFactory::create([
            'name' => 'Cat Survey',
            'settings' => ['accept-guest-entries' => true],
        ]);

        $this->assertCount(1, $survey->settings);
    }

    /** @test */
    public function testSurveyCanAddQuestions()
    {
        $survey = Survey::factory()->create();

        $survey->questions()->create(['content' => 'How many cats do you have?']);

        $this->assertEquals(1, $survey->questions->count());
    }

    /** @test */
    public function testSurveyCanAddMultipleQuestionsAtOnce()
    {
        $survey = Survey::factory()->create();

        $questions = Question::factory()->count(2)->create();

        $survey->questions()->saveMany($questions);

        $this->assertEquals(2, $survey->questions->count());
    }

    /** @test */
    public function testSurveyCombinesTheRulesOfItsQuestions()
    {
        $q1 = Question::factory()->create(['rules' => ['numeric', 'min:0']]);
        $q2 = Question::factory()->create(['rules' => ['date']]);

        $survey = Survey::factory()->create();

        $survey->questions()->saveMany([$q1, $q2]);

        $this->assertArrayHasKey($q1->key, $survey->rules);
    }

    /** @test */
    public function testSurveyHasLimitPerParticipant()
    {
        $survey = Survey::factory()->create();

        $this->assertEquals(1, $survey->limitPerParticipant());

        $anotherSurvey = new Survey([
            'settings' => ['limit-per-participant' => 5],
        ]);

        $this->assertEquals(5, $anotherSurvey->limitPerParticipant());
    }

    /** @test */
    public function testSurveyMayHaveNoLimitsPerParticipant()
    {
        $survey = SurveyFactory::create([
            'settings' => ['limit-per-participant' => -1],
        ]);

        $this->assertNull($survey->limitPerParticipant());
    }

    /** @test */
    public function testSurveyDoesNotAcceptGuestEntriesByDefault()
    {
        $survey = SurveyFactory::create();

        $this->assertFalse($survey->acceptsGuestEntries());
    }

    /** @test */
    public function testSurveyMayAcceptGuestEntries()
    {
        $survey = SurveyFactory::create([
            'settings' => ['accept-guest-entries' => true],
        ]);

        $this->assertTrue($survey->acceptsGuestEntries());
    }
}
