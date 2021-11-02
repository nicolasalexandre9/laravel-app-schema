<?php

namespace Nicolasalexandre9\LaravelAppSchema;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
