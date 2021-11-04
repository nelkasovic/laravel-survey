<div>
    @include(view()->exists("survey::questions.types.{$question->type}")
        ? "survey::questions.types.{$question->type}"
        : "survey::questions.types.text",[
            'disabled' => !($eligible ?? true),
            'value' => $lastEntry ? $lastEntry->answerFor($question) : null,
            'includeResults' => ($lastEntry ?? null) !== null
        ]
    )
</div>