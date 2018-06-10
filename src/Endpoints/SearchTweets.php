<?php

namespace Tequilarapido\Twit\Endpoints;

/**
 * Get twitter search tweets.
 *
 * @see https://developer.twitter.com/en/docs/tweets/search/api-reference/get-search-tweets.html
 *
 * Parameters sample
 *  [
 *      'q' => '@tequilarapido',
 *      'count' => 25,
 *      ...
 * ]
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
