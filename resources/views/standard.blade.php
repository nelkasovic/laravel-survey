
<div class="block block-rounded block-themed block-fx-pop">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __('common.Preview') }}</h3>
        <div class="block-options">
            <button type="button"
                    class="btn-block-option"
                    data-toggle="block-option"
                    data-action="content_toggle"></button>
        </div>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-xl-12">

                @if(!$eligible)

                    We only accept
                    <strong>{{ $survey->limitPerParticipant() }} {{ Illuminate\Support\Str::plural('entry', $survey->limitPerParticipant()) }}</strong>
                    per participant.

                @endif

                @if($lastEntry)

                    You last submitted your answers <strong>{{ $lastEntry->created_at->diffForHumans() }}</strong>.

                @endif

                @if(!$survey->acceptsGuestEntries() && auth()->guest())

                    Please login to join this survey.

                @else
                    @foreach($survey->sections as $section)
                        @include('survey::sections.single')
                        @if($survey->sections->count() > 1)
                            <hr class="mb-3">
                        @endif
                    @endforeach

                    @foreach($survey->questions()->withoutSection()->with(['media'])->get() as $question)
                        @include('survey::questions.single')
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="block-content block-content-full text-end bg-body-light">
        <div class="row">
            <div class="col-lg-12 text-end">
                @if($eligible)
                    <button class="btn btn-primary" type="submit">Submit</button>
                @endif
            </div>
        </div>
    </div>

</div>