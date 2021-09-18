<?php

namespace Wimando\Survey\Facades\Factories\Utilities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Facade;

/**
 * @method static HasMany similarAnswers($value)
 * @method static mixed similarAnswersRatio($value)
 * @method static mixed average()
 */
class Summary extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wimando\Survey\Utilities\Summary::class;
    }
}
