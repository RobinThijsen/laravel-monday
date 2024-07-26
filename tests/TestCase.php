<?php

namespace RobinThijsen\LaravelMonday\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RobinThijsen\LaravelMonday\Exceptions\ChainedNotAllowException;
use RobinThijsen\LaravelMonday\Exceptions\InvalidTokenException;
use RobinThijsen\LaravelMonday\MondayServiceProvider;
use RobinThijsen\LaravelMonday\QueryBuilder;

class TestCase extends Orchestra
{
    /**
     * @throws ChainedNotAllowException
     * @throws InvalidTokenException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $queryResult = QueryBuilder::query()
            ->getItems()
            ->creator()
            ->columnValues()
            ->get();

        dd($queryResult);
    }

    protected function getPackageProviders($app)
    {
        return [
            MondayServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
                config()->set('monday.token', 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjM4MDk1MjkxMSwiYWFpIjoxMSwidWlkIjo2MzA5OTc0NywiaWFkIjoiMjAyNC0wNy0wNVQxODoxOTozNS4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MjQyOTI3NjQsInJnbiI6ImV1YzEifQ.wB-EsA9ZDjVhyJRd8p_FaFGFywFiMWy5TPO11Tv0hQE');
    }
}
