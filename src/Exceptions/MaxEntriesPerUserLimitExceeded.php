<?php

namespace Wimando\Survey\Exceptions;

use Exception;

class MaxEntriesPerUserLimitExceeded extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Maximum entries per user exceeded.';
}
