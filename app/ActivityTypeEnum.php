<?php

namespace App;

enum ActivityTypeEnum: string
{
    case USER_INVITED = 'user_invited';
    case ACTIVITY_CREATED = 'activity_created';
}
