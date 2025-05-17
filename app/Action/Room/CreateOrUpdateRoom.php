<?php

namespace App\Action\Room;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class CreateOrUpdateRoom
{

    public function __construct(
        public RoomRequest $roomRequest,
        public ?Room       $room = null
    )
    {
    }

    public function handle(): ?Room
    {
        $user = $this->findUser();

        $this->room = $this->room ?? new Room();

        $this->room->name = $this->roomRequest->validated('name');
        $this->room->user_id = $user->id;

        $this->removeOldFile();

        $this->room->file_path = $this->uploadFile();

        $this->room->save();

        $this->room->refresh();

        return $this->room;
    }

    private function findUser(): User
    {
        return User::byNickName($this->roomRequest->validated('nick_name'))->firstOrFail();
    }

    private function uploadFile(): false|string|null
    {
        if ($this->roomRequest->hasFile('file')) {
            $file = $this->roomRequest->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('rooms', $file->getClientOriginalName(), 'public');
            return "rooms/$fileName";
        }
        return null;
    }

    private function removeOldFile(): void
    {
        if ($this->roomRequest->hasFile('file') && $this->room->file_path) {
            Storage::disk('public')->delete($this->room->file_path);
        }
    }
}
