<?php

namespace Nicolasalexandre9\LaravelAppSchema;

use Illuminate\Support\ServiceProvider;
use Nicolasalexandre9\LaravelAppSchema\Providers\EventServiceProvider;

/**
 * Class LaravelAppSchemaServiceProvider
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class LaravelAppSchemaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);

        $this->mergeConfigFrom(__DIR__ . '/../config/schema.php', 'schema');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/schema.php' => config_path('schema.php')], 'config');
    }
}
