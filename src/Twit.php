<?php

namespace TequilaRapido\Twit;

use Carbon\Carbon;

/**
 * Helper trait
 */
trait Twit
{
    /** @return TwitApps */
    protected function twitApps()
    {
        return resolve(TwitApps::class);
    }

    /**
     * Wrap a call to a twitter endpoint to be able to catch
     * a timeout exception and resume if needed using the callback.
     *
     * @param callable $run
     * @param callable $runIfTimeout
     * @return mixed
     * @throws \Exception
     */
    protected function tolerateTwitterTimeout(callable $run, callable $runIfTimeout)
    {
        try {
            return $run();
        } catch (\Exception $e) {
            if (!str_contains($e->getMessage(), 'Operation timed out')) {
                throw $e;
            }

            app()->log->error($e);

            $runIfTimeout();
        }
    }

    /**
     * Parse twitter date.
     *
     * @param $raw
     * @return null|Carbon
     */
    protected function parseTwitterDate($raw)
    {
        return $raw ? Carbon::createFromTimestamp(strtotime($raw)) : null;
    }

    /**
     * Format twitter date.
     *
     * @param $raw
     * @return null
     */
    protected function formatTwitterDate($raw)
    {
        $date = $this->parseTwitterDate($raw);

        return $date ? $date->format('Y-m-d H:i:s') : null;
    }

    protected function reportUsedApp(TwitApp $app)
    {
        $this->line(PHP_EOL . "App ID : [{$app->key}] - remaining request: [{$app->remaining()}]");
    }

    protected function reportNoAvailableApp()
    {
        $this->comment(PHP_EOL . "Waiting ... no available app!");
    }
}