<?php

declare(strict_types=1);

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Stream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class StreamRepository
{
    public function getStreamCountGroupedByName(): Collection
    {
        return DB::table((new Stream())->getTable())
            ->select('game_name', DB::raw('count(*) as streamsCount'))
            ->where('game_name', '!=', '')
            ->groupBy('game_name')
            ->orderByDesc('streamsCount')
            ->get();
    }

    public function getMedianViewersCount(): int
    {
        $rows = DB::table((new Stream())->getTable())
                ->select('viewers_count')
                ->distinct()
                ->orderBy('viewers_count')
                ->get();

        $rowCount = count($rows);

        if (!$rowCount) {
            return 0;
        }

        if ($rowCount % 2 === 0) {
            $index = $rowCount / 2;
            $topMedianBound = $rows[$index]->viewers_count;
            $bottomMedianBound = $rows[$index - 1]->viewers_count;

            $median = (int) (($topMedianBound + $bottomMedianBound) / 2);

        } else {
            $index = (int) floor($rowCount / 2);
            $median = $rows[$index]->viewers_count;
        }

        return $median;
    }

    public function getTopStreamsByViewersCount(?string $sort = 'desc'): EloquentCollection
    {
        $streams = Stream::query()
            ->orderByDesc('viewers_count')
            ->limit(100)
            ->get();

        return $streams->sortBy('viewers_count', descending: $sort === 'desc');
    }

    public function getStreamsGroupedByStartTime(): Collection
    {
        $streams = Stream::query()
            ->orderByDesc('started_at')
            ->get();

        $streams = $streams->map(function (Stream $stream) {
            /** @var Carbon $startedAt */
            $startedAt = $stream->started_at;

            if ($startedAt->minute <= 30) {
                $startedAt->floorHour();
            } else {
                $startedAt->ceilHour();
            }

            $stream->started_at = $startedAt;

            return $stream;
        });

        return $streams->groupBy(function (Stream $stream) {
            return $stream->started_at->format('Y-m-d h:i A');
        });
    }

    public function getStreamsByTwitchIds(array $twitchIds): EloquentCollection
    {
        return Stream::query()
            ->whereIn('twitch_id', $twitchIds)
            ->get();
    }
}
