<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'name' => fake()->unique()->name(),
            'code' => fake()->unique()->regexify('[A-Za-z0-9]{4}')
        ];
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function userId(int $userId): static
    {
        return $this->state([
            'user_id' => $userId
        ]);

    }
}
