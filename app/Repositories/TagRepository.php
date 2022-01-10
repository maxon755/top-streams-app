<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagRepository
{
    public function getTagsByTwitchIds(array $tagsTwitchIds): Collection
    {
        return Tag::query()
            ->whereIn('twitch_id', $tagsTwitchIds)
            ->get();
    }
}
