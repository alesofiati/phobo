<?php

namespace App\Observers;

use App\ActivityTypeEnum;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        if (! $user->room_id) {
            return;
        }

        $user->activities()->create([
            'room_id' => $user->room_id,
            'type' => ActivityTypeEnum::USER_INVITED->value,
        ]);
    }
}
