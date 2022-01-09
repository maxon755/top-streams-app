<?php

declare(strict_types=1);

namespace App\Services;

use stdClass;
use App\Models\User;
use App\Repositories\StreamRepository;
use Illuminate\Database\Eloquent\Collection;

class StreamService
{
    public function __construct(
        private TwitchApiService $twitchApiService,
        private StreamRepository $streamRepository
    )
    {
    }

    public function getUserFollowedStreamsFromTop(User $user): Collection
    {
        $followedStreamsData = $this->twitchApiService->getUserFollowedStreams(
            $user->twitch_id,
            $user->twitch_access_token
        );

        $followedStreamsIds = array_map(
            fn(stdClass $streamData) => $streamData->id,
            $followedStreamsData
        );

        return $this->streamRepository->getStreamsByTwitchIds($followedStreamsIds);
    }
}
