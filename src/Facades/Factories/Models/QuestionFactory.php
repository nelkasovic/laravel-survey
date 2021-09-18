<?php

namespace Wimando\Survey\Facades\Factories\Models;

use Illuminate\Support\Facades\Facade;
use Wimando\Survey\Models\Question;

/**
 * @method static Question create(array $attributes = [])
 */
class QuestionFactory extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wimando\Survey\Factories\Models\QuestionFactory::class;
    }
}
