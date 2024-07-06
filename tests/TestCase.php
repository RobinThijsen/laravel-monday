<?php

namespace RobinThijsen\LaravelMonday\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RobinThijsen\LaravelMonday\Exceptions\ChainedNotAllowException;
use RobinThijsen\LaravelMonday\QueryBuilder;
use RobinThijsen\LaravelMonday\MondayServiceProvider;

class TestCase extends Orchestra
{
    /**
     * @throws ChainedNotAllowException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $queryResult = QueryBuilder::query()
            ->getWorkspaces()
            ->ownersSubscribers()
            ->usersSubscribers()
            ->settings()
            ->icon()
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
//        config()->set('token', 'TEST_TOKEN_API');
    }
}
