<?php

namespace Tequilarapido\Twit;

class RateLimits
{
    public $limit;

    public $remaining;

    public $reset;

    /**
     * Construct instance from headers response.
     *
     * @param $headers
     * @return static
     */
    public static function fromHeaders($headers)
    {
        $rateLimits = new static;
        $rateLimits->limit = array_get($headers, 'x_rate_limit_limit');
        $rateLimits->remaining = array_get($headers, 'x_rate_limit_remaining');
        $rateLimits->reset = array_get($headers, 'x_rate_limit_reset');

        return $rateLimits;
    }

    /**
     * @return int seconds before rate limit reset.
     */
    public function waitTime()
    {
        return (int) $this->reset - time() + 5; /* we add 5 secs for safety !*/
    }
}
