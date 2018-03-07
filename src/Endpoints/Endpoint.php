<?php

namespace Tequilarapido\Twit\Endpoints;

use Tequilarapido\Twit\TwitApp;

abstract class Endpoint
{
    /** @var  TwitApp */
    protected $app;

    /** @var array */
    protected $parameters;

    /** @var callable */
    protected $tolerateTimeoutCallback;

    /**
     * Endpoint constructor.
     *
     * @param TwitApp $app
     */
    public function __construct(TwitApp $app)
    {
        $this->app = $app;
    }

    /** @return array */
    abstract protected function getDefaultParameters();

    /** @return mixed */
    abstract protected function execute();

    /**
     * Sets tolerate timeout callback
     *
     * @param callable $callback
     * @return $this
     */
    public function tolerateTimeout(callable  $callback)
    {
        $this->tolerateTimeoutCallback = $callback;

        return $this;
    }

    /**
     * Sets request parameters
     *
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Call twitter api either directly or resuming when timeout exception occcurs.
     *
     * We noticed that from time to time twitter api call will timeout,
     * this is a way to hook in and resume avoiding breaking the fetch process.
     *
     *
     * @return mixed
     * @throws \Exception
     */
    public function send()
    {
        // No tolorate callback ?
        if (!$this->tolerateTimeoutCallback) {
            return $this->execute();
        }

        // With timeout tolerating
        try {
            return $this->execute();
        } catch (\Exception $e) {
            if (!str_contains($e->getMessage(), 'Operation timed out')) {
                throw $e;
            }

            app()->log->error($e);

            // Reset callback for next calls
            $callback = $this->tolerateTimeoutCallback;
            $this->tolerateTimeoutCallback = null;

            return $callback();
        }
    }

    protected function getParameters()
    {
        return array_merge($this->parameters, $this->getDefaultParameters());
    }
}