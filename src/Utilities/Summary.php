<?php

namespace Wimando\Survey\Utilities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Wimando\Survey\Models\Question;

class Summary
{

    protected Question $question;

    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Find all answers with the same value.
     *
     * @param $value
     * @return HasMany
     */
    public function similarAnswers($value): HasMany
    {
        return $this->question->answers()->where('value', $value);
    }

    /**
     * Find the ratio of similar answers to all other answers.
     *
     * @param $value
     * @return float|int
     */
    public function similarAnswersRatio($value)
    {
        $total = $this->question->answers()->count();

        return $total > 0 ? $this->similarAnswers($value)->count() / $total : 0;
    }

    /**
     * Calculate the average answer.
     *
     * @return int|mixed
     */
    public function average()
    {
        return $this->question->answers()->average('value') ?? 0;
    }
}
