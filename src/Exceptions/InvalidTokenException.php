<?php

namespace RobinThijsen\LaravelMonday\Exceptions;

class InvalidTokenException extends \Exception
{
    public function __construct($message = null)
    {
        parent::__construct($message, 500);
    }
}
