<?php

namespace Tequilarapido\Twit\Endpoints;

/**
 * Get twitter user followers.
 *
 * @see https://developer.twitter.com/en/docs/accounts-and-users/follow-search-get-users/api-reference/get-followers-list
 *
 * Parameters sample
 *  [
 *      'screen_name' => $screen_name,
 *      'cursor' => $cursor,
 *      'skip_statuses' => true,
 *      'include_user_entities' => false,
 *      'count' => 200,
 * ]
 *
 */

class SearchTweets extends Endpoint
{
    protected function execute()
    {
        return $this->app->get(
            '/search/tweets', $this->getParameters()
        );
    }

    protected function getDefaultParameters()
    {
        return [

        ];
    }
}