<?php

namespace Wimando\Survey\Facades\Utilities;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array csvStringToArray(string $str = '')
 * @method static string arrayToCsvString(array $data = [])
 */
class Helper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Wimando\Survey\Utilities\Helper::class;
    }
}
