<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'room_id',
        'rating',
        'description',
        'image',
        'episode',
        'season',
        'type',
    ];
}
