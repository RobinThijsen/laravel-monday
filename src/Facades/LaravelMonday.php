<?php

namespace RobinThijsen\LaravelMonday\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RobinThijsen\LaravelMonday\Skeleton
 */
class LaravelMonday extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \RobinThijsen\LaravelMonday\LaravelMonday::class;
    }
}
