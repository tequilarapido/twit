<?php

namespace Tequilarapido\Twit\Endpoints;

/**
 * Get twitter user timeline.
 *
 * @see https://developer.twitter.com/en/docs/tweets/timelines/api-reference/get-statuses-user_timeline.html
 *
 * Parameters sample
 *  [
 *      'screen_name' => $screen_name,
 *      'count' => 200,
 *      'exclude_replies' => true,
 *      'trim_user' => true,
 *      'include_rts' => true,
 *  ]
 *
 */
class GetUserTimeline extends Endpoint
{
    protected function execute()
    {
        return $this->app->get(
            '/statuses/user_timeline', $this->getParameters()
        );
    }

    protected function getDefaultParameters()
    {
        return [
            'count' => 200,
            'exclude_replies' => true,
            'trim_user' => true,
            'include_rts' => true,
        ];
    }
}