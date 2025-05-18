<?php

namespace App\Action\Room;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Traits\HasFindUser;
use App\Traits\HasUploadFile;

class Create
{
    use HasFindUser, HasUploadFile;

    public function __construct(
        public RoomRequest $request,
        public ?Room       $room = null
    )
    {
    }

    public function handle(): ?Room
    {
        $user = $this->findUser();

        $this->room = $this->room ?? new Room;

        $this->room->name = $this->request->validated('name');
        $this->room->user_id = $user->id;

        $this->room->file_path = $this->uploadFile('file', 'rooms');

        $this->room->save();

        $this->room->refresh();

        return $this->room;
    }
}
