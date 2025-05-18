<?php

use App\Enums\ActivityTypeEnum;
use App\Models\Activity;
use App\Models\Room;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;

uses(WithFaker::class);

beforeEach(function () {
    $this->setUpFaker();
});

describe('crud activity', function () {
    describe('index', function () {
        beforeEach(function () {
            $this->activity = Activity::factory()->create();
        });

        it('returns a list of all activities', function () {
            $response = $this->getJson(route('activities.index'));

            $response->assertOk();

            $response->assertJson([
                'current_page' => 1,
                'data' => [],
                'first_page_url' => 'http://localhost/api/activities?page=1',
                'from' => null,
                'last_page' => 1,
                'last_page_url' => 'http://localhost/api/activities?page=1',
                'links' => [
                    [
                        'url' => null,
                        'label' => '&laquo; Previous',
                        'active' => false,
                    ],
                    [
                        'url' => 'http://localhost/api/activities?page=1',
                        'label' => '1',
                        'active' => true,
                    ],
                    [
                        'url' => null,
                        'label' => 'Next &raquo;',
                        'active' => false,
                    ],

                ],
                'next_page_url' => null,
                'path' => 'http://localhost/api/activities',
                'per_page' => 10,
                'prev_page_url' => null,
                'to' => null,
                'total' => 0,
            ]);
        });
    })->skip();

    describe('store', function () {
        beforeEach(function () {
            $this->room = Room::factory()->create();

            $this->payload = [
                'room_code' => $this->room->code,
                'nick_name' => $this->room->user->nick_name,
                'type' => $this->faker->randomElement(ActivityTypeEnum::values()),
                'rating' => $this->faker->numberBetween(1, 5),
                'description' => $this->faker->text,
                //'image' => $this->faker->image(),
                'episode' => $this->faker->numberBetween(1, 100),
                'season' => $this->faker->numberBetween(1, 100),
            ];
        });

        it('creates activity', function () {
            \Illuminate\Support\Facades\Storage::fake('local');
            $file = UploadedFile::fake()->image('avatar.jpg');
            $response = $this->postJson(route('activities.store'), [...$this->payload, 'image' => $file]);

            $response->assertCreated();

            assertActivityResponse($response, $this->payload);
        });
    });
});

function assertActivityResponse($response, array $payload): void
{
    $response->assertJsonStructure([
        'id',
        'room_id',
        'user_id',
        'type',
        'rating',
        'description',
        'image',
        'episode',
        'season',
    ]);

    $room = Room::find($response->json('room_id'));

    expect($room->code)->toBe($payload['code'])
        ->and($room->nick_name)->toBe($payload['nick_name']);
}
