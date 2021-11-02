<?php

namespace Nicolasalexandre9\LaravelAppSchema\Providers;

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Nicolasalexandre9\LaravelAppSchema\Listeners\ServerStart;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var \string[][]
     */
    protected $listen = [
        CommandStarting::class => [
            ServerStart::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
