<?php

namespace RobinThijsen\LaravelMonday\Exceptions;

class ChainedNotAllowException extends \Exception
{
    public function __construct($message = null)
    {
        parent::__construct($message, 405);
    }
}
