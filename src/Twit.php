<?php

namespace Tequilarapido\Twit;

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
}