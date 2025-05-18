<?php

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Room extends Model
{
    /** @use HasFactory<RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'file_path'
    ];

    protected $appends = [
        'file_url',
        'nick_name'
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            do {
                $code = strtolower(Str::random(4));
                $exists = self::whereCode($code)->exists();
            } while ($exists);
            $model->code = $code;
        });
    }

    public function getFileUrlAttribute(): string
    {
        return $this->file_path ? Storage::url($this->file_path) : '';
    }

    public function getNickNameAttribute(): string
    {
        return $this->user->nick_name;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByRoomCode(Builder $query, string $code): Builder
    {
        return $query->where('code', $code);
    }

    public function scopeByUserNickName(Builder $query, string $nickName)
    {
        return $query->whereHas('user', function ($query) use ($nickName) {
            $query->whereNickName($nickName);
        });
    }
}
