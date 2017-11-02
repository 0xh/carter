<?php

use NickyWoolf\Thrust\ThrustServiceProvider;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
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