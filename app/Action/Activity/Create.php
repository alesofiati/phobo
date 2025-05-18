<?php

namespace App\Action\Activity;

use App\ActivityTypeEnum;
use App\Http\Requests\CreateActivityRequest;
use App\Models\Activity;
use App\Models\Room;
use App\Traits\HasFindUser;
use App\Traits\HasUploadFile;

class Create
{
    use HasFindUser, HasUploadFile;

    public function __construct(
        public CreateActivityRequest $request,
        public ?Activity             $activity = null
    )
    {
    }

    public function handle(): ?Activity
    {
        $room = $this->findRoom();
        $user = $this->findUser();

        $this->activity = $this->activity ?? new Activity();

        $attributes = array_merge(
            [
                'user_id' => $user->id,
                'room_id' => $room->id,
            ],
            $this->request->only([
                'rating',
                'description',
                'episode',
                'season',
            ]),
        );

        $this->activity->fill($attributes);
        $this->activity->type = ActivityTypeEnum::ACTIVITY_CREATED->value;
        $this->activity->image = $this->uploadFile(  'image', 'activities');

        $this->activity->save();
        $this->activity->refresh();

        return $this->activity;
    }

    private function findRoom(): ?Room
    {
        return Room::byRoomCode($this->request->validated('room_code'));
    }
}
