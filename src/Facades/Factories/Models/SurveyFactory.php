<?php

namespace Wimando\Survey\Facades\Factories\Models;

use Illuminate\Support\Facades\Facade;
use Wimando\Survey\Models\Survey;

/**
 * @method static Survey create(array $attributes = [])
 */
class SurveyFactory extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wimando\Survey\Factories\Models\SurveyFactory::class;
    }
}
