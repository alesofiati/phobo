<?php

namespace App\Traits;

use App\Models\User;

trait HasFindUser
{
    private function findUser(): User
    {
        return User::byNickName($this->request->validated('nick_name'))->firstOrFail();
    }
}
