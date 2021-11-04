@component('survey::questions.base', compact('question'))
    <input type="text"
           name="{{ $question->key }}[{{ $question->getFirstOption()->id }}]"
           id="{{ $question->key }}[{{ $question->getFirstOption()->id }}]"
           class="form-control"
           value="{{ $question->getFirstOption()->value ?? old($question->key.'.'.$question->getFirstOption()->id) }}" {{ ($disabled ?? false) ? 'disabled' : '' }}>
@endcomponent