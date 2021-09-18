<?php

namespace Wimando\Survey\Tests;

use Wimando\Survey\Facades\Factories\Models\EntryFactory;
use Wimando\Survey\Facades\Factories\Models\QuestionFactory;
use Wimando\Survey\Models\Entry;
use Wimando\Survey\Models\Survey;
use Wimando\Survey\Utilities\Summary;

class SummaryTest extends TestCase
{
    /** @test */
    public function testSummaryProvidesSimilarAnswers()
    {
        /** @var Survey $survey */
        $survey = Survey::factory()->create(['settings' => ['accept-guest-entries' => true]]);

        $question = QuestionFactory::create(
            [
                'content' => 'How many cats do you have?',
                'type' => 'number',
                'rules' => ['numeric', 'min:0']
            ]
        );

        $survey->questions()->save($question);

        EntryFactory::create()->for($survey)->fromArray(['q1' => 'A'])->push();
        EntryFactory::create()->for($survey)->fromArray(['q1' => 'A'])->push();
        EntryFactory::create()->for($survey)->fromArray(['q1' => 'B'])->push();
        EntryFactory::create()->for($survey)->fromArray(['q1' => 'B'])->push();

        $summary = (new Summary($question));
        $this->assertCount(2, $summary->similarAnswers('A')->get());
        $this->assertEquals(0.5, $summary->similarAnswersRatio('A'));
    }

    /** @test */
    public function testSummaryProvidesAverageAnswer()
    {
        /** @var Survey $survey */
        $survey = Survey::factory()->create(['settings' => ['accept-guest-entries' => true]]);

        $question = QuestionFactory::create([
            'content' => 'How many cats do you have?',
            'type' => 'number',
            'rules' => ['numeric', 'min:0']
        ]);

        $survey->questions()->save($question);

        (new Entry)->for($survey)->fromArray(['q1' => '2'])->push();
        (new Entry)->for($survey)->fromArray(['q1' => '6'])->push();

        $summary = (new Summary($question));
        $this->assertEquals(4, $summary->average());
    }
}
