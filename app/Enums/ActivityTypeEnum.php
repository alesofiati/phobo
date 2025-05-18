<?php

namespace App\Enums;

enum ActivityTypeEnum: string
{
    case USER_INVITED = 'user_invited';
    case ACTIVITY_CREATED = 'activity_created';

    public static function values(): array
    {
        return array_map(fn($enum) => $enum->value, self::cases());
    }
}
