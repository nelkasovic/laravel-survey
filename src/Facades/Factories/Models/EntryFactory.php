<?php

namespace Wimando\Survey\Facades\Factories\Models;

use Illuminate\Support\Facades\Facade;
use Wimando\Survey\Models\Entry;

/**
 * @method static Entry create(array $attributes = [])
 */
class EntryFactory extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wimando\Survey\Factories\Models\EntryFactory::class;
    }
}
