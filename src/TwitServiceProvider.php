<?php

namespace TequilaRapido\Twit;

use Illuminate\Support\ServiceProvider;

class TwitterAppServiceProvider extends ServiceProvider
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
    }
}