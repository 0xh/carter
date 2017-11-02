<?php

namespace Tests;

use Mockery;
use NickyWoolf\Thrust\ThrustServiceProvider;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../src/routes.php';
        }
    }

    protected function tearDown()
    {
        parent::tearDown();

        if (class_exists(Mockery::class)) {
            Mockery::close();
        }
    }

    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
            ThrustServiceProvider::class,
        ];
    }
}