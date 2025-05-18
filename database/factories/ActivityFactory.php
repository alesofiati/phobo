<?php

namespace Database\Factories;

use App\ActivityTypeEnum;
use App\Models\Activity;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            //'user_id' => User::factory()->create()->id,
            //'room_id' => Room::factory()->create()->id,
            'type' => $this->faker->randomElement(ActivityTypeEnum::values()),
            'rating' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->text(),
            'image' => $this->faker->image(),
            'episode' => $this->faker->numberBetween(1, 100),
            'season' => $this->faker->numberBetween(1, 100),
        ];
    }

    public function byRoomId(int $roomId): static
    {
        return $this->state(function () use ($roomId) {
            return [
                'room_id' => $roomId,
            ];
        });
    }

    public function activityCreated(): static
    {
        return $this->state(function () {
            return [
                'type' => ActivityTypeEnum::ACTIVITY_CREATED->value,
            ];
        });
    }
}
