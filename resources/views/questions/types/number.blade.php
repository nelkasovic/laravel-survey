@component('survey::questions.base', compact('question'))
    <input type="number"
           name="{{ $question->key }}[{{ $question->getFirstOption()->id }}]"
           id="{{ $question->key }}[{{ $question->getFirstOption()->id }}]"
           class="form-control"
           value="{{ $question->getFirstOption()->value ?? old($question->key.'.'.$question->getFirstOption()->id) }}" {{ ($disabled ?? false) ? 'disabled' : '' }}>

    @slot('report')
        @if($includeResults ?? false)
            {{ number_format((new \Wimando\Survey\Utilities\Summary($question))->average(), 2) }} (Average)
        @endif
    @endslot
@endcomponent