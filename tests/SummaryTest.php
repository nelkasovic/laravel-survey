<?php

namespace Wimando\Survey\Tests;

use Wimando\Survey\Models\Entry;
use Wimando\Survey\Models\Question;
use Wimando\Survey\Models\Survey;
use Wimando\Survey\Utilities\Summary;

class SummaryTest extends TestCase
{
    /** @test */
    public function it_provides_similar_answers()
    {
        $survey = create(Survey::class, ['settings' => ['accept-guest-entries' => true]]);

        $question = make(Question::class);

        $survey->questions()->save($question);

        (new Entry)->for($survey)->fromArray(['q1' => 'A'])->push();
        (new Entry)->for($survey)->fromArray(['q1' => 'A'])->push();
        (new Entry)->for($survey)->fromArray(['q1' => 'B'])->push();
        (new Entry)->for($survey)->fromArray(['q1' => 'B'])->push();

        $summary = (new Summary($question));
        $this->assertCount(2, $summary->similarAnswers('A')->get());
        $this->assertEquals(0.5, $summary->similarAnswersRatio('A'));
    }

    /** @test */
    public function it_provides_average_answer()
    {
        $survey = create(Survey::class, ['settings' => ['accept-guest-entries' => true]]);

        $question = make(Question::class);

        $survey->questions()->save($question);

        (new Entry)->for($survey)->fromArray(['q1' => '2'])->push();
        (new Entry)->for($survey)->fromArray(['q1' => '6'])->push();

        $summary = (new Summary($question));
        $this->assertEquals(4, $summary->average());
    }
}
