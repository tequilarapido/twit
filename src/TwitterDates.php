<?php

namespace Tequilarapido\Twit;

use Carbon\Carbon;

class TwitterDates
{
    /**
     * Parse twitter raw date.
     *
     * @param string $twitterDate
     *
     * @return Carbon|null
     */
    public static function parse($twitterDate)
    {
        return $twitterDate ? Carbon::createFromTimestamp(strtotime($twitterDate)) : null;
    }

    /**
     * Format twitter date to `Y-m-d H:i:s`.
     *
     * @param string $twitterDate
     * @return null
     */
    public static function formatToMysql($twitterDate)
    {
        $date = static::parseTwitterDate($twitterDate);

        return $date ? $date->format('Y-m-d H:i:s') : null;
    }
}