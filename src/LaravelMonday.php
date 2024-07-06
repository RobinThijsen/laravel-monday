<?php

namespace RobinThijsen\LaravelMonday;

use TBlack\MondayAPI\MondayBoard;
use TBlack\MondayAPI\Token;

class LaravelMonday
{
    private MondayBoard $MondayBoard;

    public function __construct() {
        $this->MondayBoard = new MondayBoard();
        $token = new Token(config('laravelmonday.token'));
        $this->MondayBoard->setToken($token);
    }

    public function queryResult($query): QueryResult
    {
        return new QueryResult($this->MondayBoard->customQuery($query), $query);
    }
}
