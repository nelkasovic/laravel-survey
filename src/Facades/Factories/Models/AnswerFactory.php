<?php

namespace Wimando\Survey\Facades\Factories\Models;

use Illuminate\Support\Facades\Facade;
use Wimando\Survey\Models\Answer;

/**
 * @method static Answer create(array $attributes = [])
 */
class AnswerFactory extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wimando\Survey\Factories\Models\AnswerFactory::class;
    }
}
