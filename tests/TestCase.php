<?php

namespace Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Webkul\CustomFields\CustomFieldsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            CustomFieldsServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'sqlite_memory');
        $app['config']->set('database.connections.sqlite_memory', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
