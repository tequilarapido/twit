<?php

namespace Tequilarapido\Twit\Endpoints;

trait EndpointAliases
{
    public function getFollowers()
    {
        return new GetFollowers($this);
    }

    public function getUserTimeline()
    {
        return new GetUserTimeline($this);
    }

    public function searchTweets()
    {
        return new SearchTweets($this);
    }
}
