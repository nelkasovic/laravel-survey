<?php

namespace Wimando\Survey\Factories\Models;

use Illuminate\Support\Facades\App;
use Wimando\Survey\Models\Section;

class SectionFactory
{
    public function create(array $attributes = []): Section
    {
        return App::make(Section::class, ['attributes' => $attributes]);
    }
}
