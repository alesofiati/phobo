<?php

namespace App\Http\Controllers\Api;

use App\Action\Room\CreateOrUpdateRoom;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if (!$request->get('nick_name')) {
            return $this->errorResponse('nick_name is required', 400);
        }

        $rooms = Room::byUserNickName($request->get('nick_name'))
            ->select('id', 'name', 'code', 'created_at')
            ->paginate($request->get('per_page', 10));

        return response()->json($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        $room = (new CreateOrUpdateRoom($request))->handle();
        return response()->json($room, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
