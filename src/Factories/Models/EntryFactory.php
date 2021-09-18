<?php

namespace Wimando\Survey\Factories\Models;

use Illuminate\Support\Facades\App;
use Wimando\Survey\Models\Entry;

class EntryFactory
{
    public function create(array $attributes = []): Entry
    {
        return App::make(Entry::class, ['attributes' => $attributes]);
    }
}
