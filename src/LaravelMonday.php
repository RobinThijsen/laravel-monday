<?php

namespace RobinThijsen\LaravelMonday;

use RobinThijsen\LaravelMonday\Exceptions\InvalidTokenException;
use TBlack\MondayAPI\MondayBoard;
use TBlack\MondayAPI\Token;

class LaravelMonday
{
    private MondayBoard $MondayBoard;

    public function __construct()
    {
        $this->MondayBoard = new MondayBoard();
        $token = new Token(config('monday.token'));
        $this->MondayBoard->setToken($token);
    }

    /**
     * @param $query
     * @return QueryResult
     * @throws InvalidTokenException
     */
    public function queryResult($query): QueryResult
    {
        $result = $this->MondayBoard->customQuery($query);

        if (is_null($result)) {
            throw new InvalidTokenException('Invalid token provided');
        }

        return new QueryResult($result, $query);
    }
}
