<?php

namespace Wimando\Survey\Exceptions;

use Exception;

class GuestEntriesNotAllowedException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Login is required for this survey.';
}
