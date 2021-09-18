<?php

namespace Wimando\Survey\Tests;

use Wimando\Survey\Models\Answer;

class AnswerTest extends TestCase
{
    /** @test */
    public function testAnswerHasAValue()
    {
        $answer = Answer::factory(['value' => 'Five'])->create();

        $this->assertEquals('Five', $answer->value);
    }
}
