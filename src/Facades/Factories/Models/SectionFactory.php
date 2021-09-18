<?php

namespace Wimando\Survey\Facades\Factories\Models;

use Illuminate\Support\Facades\Facade;
use Wimando\Survey\Models\Section;

/**
 * @method static Section create(array $attributes = [])
 */
class SectionFactory extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wimando\Survey\Factories\Models\SectionFactory::class;
    }
}
