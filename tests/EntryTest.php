<?php

namespace Wimando\Survey\Tests;

use Wimando\Survey\Facades\Factories\Models\EntryFactory;
use Wimando\Survey\Models\Entry;
use Wimando\Survey\Models\Question;
use Wimando\Survey\Models\Survey;

class EntryTest extends TestCase
{
    /** @test */
    public function testEntryCanBeCreatedFromArray()
    {
        $newEntry = EntryFactory::create();
        $entry = $newEntry->fromArray([
            1 => 'Five',
            2 => 'None of the above',
        ]);

        $this->assertEquals(2, $entry->answers->count());
    }

    /** @test */
    public function testEntryAcceptsASurvey()
    {
        $survey = $this->createSurvey();

        $newEntry = EntryFactory::create();
        $entry = $newEntry->for($survey);

        $this->assertEquals($survey->id, $entry->survey->id);
    }

    /** @test */
    public function testEntryAcceptsAParticipant()
    {
        $user = $this->signIn();
        $newEntry = EntryFactory::create();
        $entry = $newEntry->by($user);

        $this->assertEquals($user->id, $entry->participant->id);
    }

    /** @test */
    public function testEntryCanChainMethodCalls()
    {
        /** @var Survey $survey */
        $survey = $this->createSurvey();

        $entry = EntryFactory::create();

        $entry->fromArray([
            1 => 'Five',
            2 => 'None of the above',
        ])->for($survey)->push();

        $this->assertEquals($entry->id, $survey->entries->first()->id);
    }

    protected function createSurvey($questionsCount = 2)
    {
        $survey = Survey::factory()->create(['settings' => ['accept-guest-entries' => true]]);
        $questions = Question::factory()->count($questionsCount)->create();

        $survey->questions()->saveMany($questions);

        return $survey;
    }
}
