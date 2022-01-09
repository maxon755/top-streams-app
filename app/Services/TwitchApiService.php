<?php

declare(strict_types=1);

namespace App\Services;

use romanzipp\Twitch\Twitch;

class TwitchApiService
{
    public function __construct(private Twitch $twitch)
    {
    }

    public function getUserFollowedStreams(int $userTwitchId, string $accessToken): array
    {
        $response = $this->twitch->withToken($accessToken)->getFollowedStreams([
            'user_id' => $userTwitchId
        ]);

        return $response->data();
    }
}
