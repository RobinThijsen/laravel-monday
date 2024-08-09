<?php

namespace RobinThijsen\LaravelMonday\Exceptions;

class InvalidFieldUsageException extends \Exception
{
    public function __construct($message = null)
    {
        parent::__construct($message, 500);
    }
}
