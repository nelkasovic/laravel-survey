<?php

namespace Wimando\Survey\Facades\Factories\Utilities;

use Illuminate\Support\Facades\Facade;
use Wimando\Survey\Models\Survey;

/**
 * @method static Survey create(array $attributes)
 */
class SummaryFactory extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wimando\Survey\Factories\Utilities\SummaryFactory::class;
    }
}
