<?php

namespace Database\Factories;

use App\Enums\ActivityTypeEnum;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
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
