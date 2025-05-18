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
use Illuminate\Support\Facades\Storage;

class Activity extends Model
{
    /** @use HasFactory<ActivityFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'room_id',
        'type',
        'rating',
        'description',
        'image',
        'episode',
        'season',
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Storage::url($this->image) : '';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
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
