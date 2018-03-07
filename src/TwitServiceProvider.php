<?php

namespace Tequilarapido\Twit;

use Illuminate\Support\ServiceProvider;

class TwitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/twit.php' => config_path('twit.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/twit.php', 'twit');

        $this->app->singleton(TwitApps::class, function ($app) {
            return new TwitApps($app['config']['twit']['apps']);
        });
    }
}