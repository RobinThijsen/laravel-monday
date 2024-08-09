<?php

namespace RobinThijsen\LaravelMonday\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RobinThijsen\LaravelMonday\Exceptions\InvalidFieldException;
use RobinThijsen\LaravelMonday\Exceptions\InvalidFieldUsageException;
use RobinThijsen\LaravelMonday\Exceptions\InvalidTokenException;
use RobinThijsen\LaravelMonday\MondayServiceProvider;
use RobinThijsen\LaravelMonday\Objects\Account;
use RobinThijsen\LaravelMonday\Objects\Block;
use RobinThijsen\LaravelMonday\Objects\Board;
use RobinThijsen\LaravelMonday\Objects\Doc;
use RobinThijsen\LaravelMonday\Objects\Team;
use RobinThijsen\LaravelMonday\Objects\User;

class TestCase extends Orchestra
{
    /**
     * @throws InvalidTokenException
     * @throws InvalidFieldUsageException
     * @throws InvalidFieldException
     * @throws \ErrorException
     */
    protected function setUp(): void
    {
        parent::setUp();
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
