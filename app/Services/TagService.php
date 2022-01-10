<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\TagRepository;
use App\Services\StreamsUpdater\TagsFetcher;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    public function __construct(
        private TwitchApiService $twitchApiService,
        private TagRepository $tagRepository,
        private TagsFetcher $tagsFetcher,
    )
    {
    }

    public function getUserSharedTags(User $user): Collection
    {
        $followedStreamsData = $this->twitchApiService->getUserFollowedStreams(
            $user->twitch_id,
            $user->twitch_access_token
        );

        $tagsTwitchIds = $this->tagsFetcher->fetchTagsIds($followedStreamsData);

        return $this->tagRepository->getTagsByTwitchIds($tagsTwitchIds);
    }
}
