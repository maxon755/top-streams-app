<?php

declare(strict_types=1);

namespace App\Services\StreamsUpdater;

use App\Models\Tag;
use App\Models\Stream;
use Illuminate\Support\Facades\DB;

class StreamsUpdater
{
    private const TOP_STREAMS_COUNT = 1000;

    public function __construct(
        private TwitchClient $twitchClient,
        private TagsFetcher $tagsFetcher,
        private DataFormatter $dataFormatter,
    )
    {
    }

    public function updateStreams()
    {
        $streamsData = $this->twitchClient->getStreamsData(self::TOP_STREAMS_COUNT);

        $tagIds = $this->tagsFetcher->fetchTagsIds($streamsData);

        $tagsData = $this->twitchClient->getTagsDataByIds($tagIds);

        $formattedStreamsData = $this->dataFormatter->formatSteamsData($streamsData);
        $formattedTagsData = $this->dataFormatter->formatTagsData($tagsData);

        shuffle($formattedStreamsData);

        $this->save($formattedStreamsData, $formattedTagsData);


    }

    private function save(array $streamsData, array $tagsData)
    {
        DB::statement('LOCK TABLES streams WRITE, tags WRITE');

        DB::table('streams')->truncate();
        DB::table('tags')->truncate();

        Stream::insert($streamsData);
        Tag::insert($tagsData);

        DB::statement('UNLOCK TABLES');
    }
}
