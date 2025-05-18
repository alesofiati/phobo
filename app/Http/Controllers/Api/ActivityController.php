<?php

namespace App\Http\Controllers\Api;

use App\Action\Activity\Create;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateActivityRequest;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Activity::all(),
        );
    }

    public function store(CreateActivityRequest $request): JsonResponse
    {
        $activity = (new Create($request))->handle();

        return response()->json($activity);
    }

    public function delete(int $id): JsonResponse
    {
        Activity::destroy($id);

        return response()->json([], 204);
    }
}
