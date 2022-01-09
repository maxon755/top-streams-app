<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $twitchId
 * @property string $title
 * @property string $game_name
 * @property int number_of_viewers
 * @property DateTimeInterface $started_at
 */
class Stream extends Model
{
    use HasFactory;

    protected $casts = [
        'started_at' => 'datetime',
    ];
}
