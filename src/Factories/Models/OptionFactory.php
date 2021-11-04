<?php

namespace Wimando\Survey\Factories\Models;

use Illuminate\Support\Facades\App;
use Wimando\Survey\Models\Option;

class OptionFactory
{
    public function create(array $attributes = []): Option
    {
        return App::make(Option::class, ['attributes' => $attributes]);
    }
}
