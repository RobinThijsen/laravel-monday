<?php

namespace RobinThijsen\LaravelMonday\API;

class Token
{
    private $token = false;

    function __construct($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }
}
