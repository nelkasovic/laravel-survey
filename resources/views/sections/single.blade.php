<div class="mb-3">
    @foreach($section->questions as $question)
        @include('survey::questions.single')
    @endforeach
</div>