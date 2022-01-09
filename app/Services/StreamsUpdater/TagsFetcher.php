<?php

declare(strict_types=1);

namespace App\Services\StreamsUpdater;

use StdClass;

class TagsFetcher
{
    public function fetchTagsIds(array $streamsData): array
    {
        $tagIds = [];

        /**
         * @var StdClass $streamsData
         */
        foreach ($streamsData as $streamData) {
            $streamTagIds = $streamData->tag_ids;

            $tagIds = array_merge($tagIds, $streamTagIds ?? []);
        }

        return array_values(array_unique($tagIds));
    }
}
