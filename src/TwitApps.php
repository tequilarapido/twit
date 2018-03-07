<?php

namespace Tequilarapido\Twit;

use Illuminate\Support\Collection;

class TwitApps
{
    /** @var Collection */
    private $pool;

    /** @var  TwitApp */
    private $current;

    public function __construct($apps)
    {
        $this->pool = collect($apps)->map(function ($config, $key) {
            return new TwitApp($key, $config);
        });
    }

    /** @return TwitApp */
    public function getAvailable()
    {
        $this->current = $this->pool->first(function (TwitApp $app) {
            return $app->available();
        });

        if (!$this->current) {
            // We will return the first one to get the rate limits so we can sleep
            // and wait for reset
            $this->current = $this->pool->get(0);
        }

        return $this->current;
    }

    public function waitTime()
    {
        $waitTime = $this->pool->map(function (TwitApp $app) {
            if ($app->rateLimits) {
                return $app->rateLimits->waitTime();
            }
            return null;
        })->filter()->min();


        return $waitTime ?: 0;
    }

    public function resetRateLimits()
    {
        $this->pool->each(function (TwitApp $app) {
            return $app->rateLimits = null;
        });
    }

}