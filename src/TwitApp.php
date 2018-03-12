<?php

namespace Tequilarapido\Twit;

use Abraham\TwitterOAuth\TwitterOAuth;
use Tequilarapido\Twit\Endpoints\EndpointAliases;

class TwitApp
{
    use EndpointAliases;

    /** @var string */
    public $key;

    /** @var RateLimits */
    public $rateLimits;

    /** @var TwitterOAuth */
    private $client;

    /** @var callable */
    private $tolerateTimeoutCallback;

    /**
     * TwitApp constructor.
     *
     * @param $key
     * @param $config
     */
    public function __construct($key, $config)
    {
        $this->key = $key;

        $this->client = new TwitterOAuth(
            $config['consumer_key'],
            $config['consumer_secret'],
            $config['access_token'],
            $config['access_token_secret']
        );
    }

    /**
     * Tolerate twitter timeout for next call.
     *
     * @param callable $callable
     *
     * @return $this
     */
    public function tolerateTimeout(callable $callable)
    {
        $this->tolerateTimeoutCallback = $callable;

        return $this;
    }

    /**
     * Get TwitterOAuth client.
     *
     * @return TwitterOAuth
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Determine if the app is available for use (Rate limit not hit yet).
     *
     *
     * @return bool
     */
    public function available()
    {
        if (empty($this->rateLimits)) {
            return true;
        }

        return $this->rateLimits->remaining > 0;
    }

    /**
     * Remaining requests before hitting the limit.
     *
     * @return int
     */
    public function remaining()
    {
        return $this->rateLimits ? $this->rateLimits->remaining : 0;
    }

    /**
     * Forwarded get call to client and catches rate limits.
     *
     * @param $endpoint
     * @param $parameters
     *
     * @return object
     */
    public function get($endpoint, $parameters)
    {
        $response = $this->client->get($endpoint, $parameters);

        $this->rateLimits = RateLimits::fromHeaders($this->client->getLastXHeaders());

        return $response;
    }

    /**
     * Return the current rate limit status for a specific endpoint.
     *
     * ie. getRatelimitStatus('followers', '/followers/list')
     *
     * @param $resource
     * @param $endpoint
     * @return object
     */
    public function getRatelimitStatus($resource, $endpoint)
    {
        $response = $this->client->get('application/rate_limit_status', ['resource' => $resource]);

        return object_get($response, "resources.{$resource}.{$endpoint}");
    }
}
