<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        return response()->json(
            $user->only(['id', 'nick_name'])
        , 201);
    }

    public function verify(Request $request)
    {
        $nickName = $request->get('nick_name', '');

        $nickNameExists = User::byNickName($nickName)->exists();

        return response()->json([
            'message' => trans($nickNameExists ? 'messages.nick_name_already_exists' : 'messages.nick_name_available'),
        ], $nickNameExists ? 409 : 200);
    }
}
