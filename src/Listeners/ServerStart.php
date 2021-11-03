<?php

namespace Nicolasalexandre9\LaravelAppSchema\Listeners;

use Illuminate\Console\Events\CommandStarting;
use Nicolasalexandre9\LaravelAppSchema\Schema\AppSchema;

/**
 * Class ServerStart
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class ServerStart
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \Illuminate\Console\Events\CommandStarting $event
     * @return void
     * @throws \ReflectionException
     */
    public function handle(CommandStarting $event)
    {
        if ($event->command === 'serve') {
            (new AppSchema())->createSchema();
        }
    }
}
