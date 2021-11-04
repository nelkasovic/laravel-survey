<div class="form-group mb-4">
    <label class="mb-2" for="{{ $question->key }}">
        {{ $question->content }}
    </label>

    {{ $slot }}
    @if($errors->has($question->key))
        <div class="text-danger mt-3">{{ $errors->first($question->key) }}</div>
    @elseif($errors->has("$question->key.*"))
        <div class="text-danger mt-3">{{ $errors->first("$question->key.*") }}</div>
    @endif

</div>

<div class="text-success">
    {{ $report ?? '' }}
</div>
