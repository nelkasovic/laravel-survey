<?php

namespace Wimando\Survey\Utilities;

class Helper
{
    public function arrayToCsvString(array $data = []): string
    {
        return implode(',', $data);
    }

    public function csvStringToArray(string $str = ''): array
    {
        return explode(',', $str);
    }
}