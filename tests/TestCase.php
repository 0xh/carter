<?php

namespace Tests;

use Mockery;
use NickyWoolf\Carter\CarterServiceProvider;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../src/routes.php';
        }

        config(['auth.providers.users.model' => User::class]);
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
            CarterServiceProvider::class,
        ];
    }

    protected function migrate()
    {
        $this->loadLaravelMigrations([
            '--database' => 'testing',
        ]);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../src/migrations'),
        ]);

        return $this;
    }

    protected function withFactories($path = null)
    {
        return parent::withFactories($path ?: __DIR__.'/Factories');
    }
}