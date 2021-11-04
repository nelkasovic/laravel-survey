@component('survey::questions.base', compact('question'))
    @foreach($question->options as $option)
        <div class="form-check mb-1">
            <input type="radio"
                   name="{{ $question->key }}[{{$option->id}}]"
                   id="{{ $question->key . '-' . $option->id}}"
                   value="{{ $option->value }}"
                   class="form-check-input"
                    {{ ($value ?? old($question->key)) == $option->value ? 'checked' : '' }}
                    {{ ($disabled ?? false) ? 'disabled' : '' }}
            >
            <label class="form-check-label ms-1"
                   for="{{ $question->key . '-' . $option->id }}">{{ $option->value }}
                @if($includeResults ?? false)
                    <span class="text-success">
                        ({{ number_format((new \Wimando\Survey\Utilities\Summary($question))->similarAnswersRatio($option) * 100, 2) }}%)
                    </span>
                @endif
            </label>
        </div>
    @endforeach
@endcomponent