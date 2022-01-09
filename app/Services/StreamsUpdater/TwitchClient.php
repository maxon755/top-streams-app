<?php

declare(strict_types=1);

namespace App\Services\StreamsUpdater;

use romanzipp\Twitch\Twitch;

class TwitchClient
{
    private const TWITCH_MAX_PAGE_SIZE = 100;

    public function __construct(private Twitch $twitchClient)
    {
    }

    public function getStreamsData(int $streamsCount): array
    {
        $streamData = [];

        do {
            $nextCursor = null;

            if (isset($result)) {
                $nextCursor = $result->next();
            }

            $result =  $this->twitchClient->getStreams(['first' => self::TWITCH_MAX_PAGE_SIZE], $nextCursor);

            $streamData = array_merge($streamData, $result->data());

        } while (count($streamData) < $streamsCount && $result->hasMoreResults());

        if (count($streamData) > $streamsCount) {
            $streamData = array_slice($streamData, 0, $streamsCount);
        }

        return $streamData;
    }

    public function getTagsDataByIds(array $tagIds): array
    {
        $tagsData = [];

        foreach (array_chunk($tagIds, self::TWITCH_MAX_PAGE_SIZE) as $tagIdsChunk)
        {
            $nextCursor = null;

            if (isset($result)) {
                $nextCursor = $result->next();
            }

            $result =  $this->twitchClient->getAllStreamTags([
                'tag_id' => $tagIdsChunk
            ], $nextCursor);

            $tagsData = array_merge($tagsData, $result->data());
        }

        return $tagsData;
    }
}
