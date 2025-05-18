<?php

namespace App\Http\Controllers\Api;

use App\Action\Room\Create;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $this->validateNickName($request);

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
        $room = (new Create($request))->handle();

        return response()->json($room, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code, Request $request)
    {
        $this->validateNickName($request);

        $nickName = $request->get('nick_name');

        $room = Room::whereCode($code)
            ->with('user')
            ->firstOrFail();

        if ($room->user->nick_name !== $nickName) {
            $user = User::byNickName($nickName)->firstOrFail();
            if ($room->id !== $user->room_id) {
                return response()->json(['message' => 'Room not found'], 404);
            }
        }

        return response()->json($room->except(['created_at', 'updated_at']));
    }

    /**
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request)
    {
        $this->validateNickName($request);

        $room = Room::byUserNickName($request->get('nick_name'))->findOrFail($id);
        $room->delete();

        return response()->json([], 204);
    }

    private function validateNickName(Request $request): void
    {
        if (!$request->get('nick_name', '')) {
            throw new HttpResponseException(
                $this->errorResponse('nick_name is required', 400)
            );
        }
    }
}
