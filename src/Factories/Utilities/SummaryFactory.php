<?php

namespace Wimando\Survey\Factories\Utilities;

use Illuminate\Support\Facades\App;
use Wimando\Survey\Utilities\Summary;

class SummaryFactory
{
    public function create(array $attributes = []): Summary
    {
        return App::make(Summary::class, ['attributes' => $attributes]);
    }
}
