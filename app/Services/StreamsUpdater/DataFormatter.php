<?php

declare(strict_types=1);

namespace App\Services\StreamsUpdater;

use stdClass;
use DateTimeImmutable;

class DataFormatter
{

    public function formatSteamsData(array $streamsData): array
    {
        return array_map(function (stdClass $stream) {

            $startedAt = new DateTimeImmutable($stream->started_at);
            $startedAt = $startedAt->format('Y-m-d H:i:s');

            return [
                'twitch_id' => $stream->id,
                'channel_name' => $stream->user_name,
                'title' => $stream->title,
                'game_name' => $stream->game_name,
                'number_of_viewers' => $stream->viewer_count,
                'started_at' => $startedAt,
            ];
        }, $streamsData);
    }

    public function formatTagsData(array $tagsData): array
    {
        return array_map(function (stdClass $tag) {

            return [
                'twitch_id' => $tag->tag_id,
                'name' => $tag->localization_names->{'en-us'} ?? array_shift($tag->localization_names),
            ];
        }, $tagsData);
    }
}
