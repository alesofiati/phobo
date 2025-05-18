<?php

namespace App\Models;

use App\ActivityTypeEnum;
use Database\Factories\ActivityFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    /** @use HasFactory<ActivityFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'room_id',
        'rating',
        'description',
        'image',
        'episode',
        'season',
        'type',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[Scope]
    protected function activityCreated(Builder $query)
    {
        return $query->where('type', ActivityTypeEnum::ACTIVITY_CREATED->value);
    }

    #[Scope]
    protected function byRoomCode(Builder $query, string $code)
    {
        return $query->whereHas('room', function ($query) use ($code) {
            $query->where('code', $code);
        });
    }
}
