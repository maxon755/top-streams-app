<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $twitchId
 * @property string $name
 */
class Tag extends Model
{
    use HasFactory;
}
