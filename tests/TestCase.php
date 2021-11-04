<?php

namespace Nicolasalexandre9\LaravelAppSchema\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Nicolasalexandre9\LaravelAppSchema\LaravelAppSchemaServiceProvider;

/**
 * Class TestCase
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        Config::set('schema.models_directory_path', __DIR__ . '/Models');
        Config::set('schema.schema_file_path', __DIR__ . '/tmp/.forestadmin-schema-test.json');
    }


    /**
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelAppSchemaServiceProvider::class,
        ];
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}
