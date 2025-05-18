<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->has('room_code')) {
            return $this->errorResponse('room_code is required', 400);
        }

        $activities = Activity::activityCreated()
            ->byRoomCode($request->room_code)
            ->with('user:id,nick_name')
            ->selectRaw('user_id, COUNT(*) as total')
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
        ->get();

        return response()->json(
            $activities->map(function ($activity) {
                return [
                    'nick_name' => $activity->user->nick_name,
                    'total' => $activity->total,
                ];
            })
        );
    }
}
