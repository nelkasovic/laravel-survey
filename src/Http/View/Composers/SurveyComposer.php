<?php

namespace Wimando\Survey\Http\View\Composers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\View\View;

class SurveyComposer
{
    protected Guard $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function compose(View $view)
    {
        $view->with([
            'eligible' => $view->survey->isEligible($this->auth->user()),
            'lastEntry' => $view->survey->lastEntry(auth()->user()),
        ]);
    }
}
