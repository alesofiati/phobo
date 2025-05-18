<?php

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\UploadedFile;

describe('crud rooms', function () {

    describe('index', function () {
        beforeEach(function () {
            $this->user = User::factory()->create();
        });

        it('returns bad request when the \'nick_name\' query parameter is missing', function () {
            $response = $this->getJson(route('rooms.index'));
            $response->assertBadRequest();
        })
        ->skip();

        it('return a list of rooms', function () {
            $params = [
                'nick_name' => $this->user->nick_name,
                'per_page' => 10,
                'teste' => 'dadas'
            ];
            $response = $this->getJson(
                route("rooms.index", $params)
            );
            $response->assertOk();

            $response->assertJson([
                'current_page' => 1,
                'data' => [],
                'first_page_url' => 'http://localhost/api/rooms?page=1',
                'from' => null,
                'last_page' => 1,
                'last_page_url' => 'http://localhost/api/rooms?page=1',
                'links' => [
                    [
                        'url' => null,
                        'label' => '&laquo; Previous',
                        'active' => false,
                    ],
                    [
                        'url' => 'http://localhost/api/rooms?page=1',
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
                'path' => 'http://localhost/api/rooms',
                'per_page' => 10,
                'prev_page_url' => null,
                'to' => null,
                'total' => 0,
            ]);
        });
    });

    describe('store', function () {
        beforeEach(function () {
            $this->user = User::factory()->create();
            $this->payload = [
                'nick_name' => $this->user->nick_name,
                'name' => fake()->name
            ];
        });

        it('return unprocessable entity', function () {
            $response = $this->postJson(route('rooms.store'));
            $response->assertUnprocessable();
            $response->assertJsonValidationErrors([
                'nick_name',
                'name',
            ]);
            $response->assertJsonStructure([
                'message',
                'errors' => [
                    'nick_name',
                    'name'
                ]
            ]);
        });

        test('create a new room', function () {
            $response = $this->postJson(route('rooms.store'), $this->payload);

            $response->assertCreated();

            assertRoomResponse($response, $this->payload);
        });

        test('returns unprocessable entity when the file is not an image', closure: function () {

            $fakeFile = UploadedFile::fake()->create(
                'room.pdf',
                1024,
                'application/pdf'
            );

            $payload = [
                ...$this->payload,
                'file' => $fakeFile
            ];

            $response = $this->postJson(route('rooms.store'), $payload);
            $response->assertUnprocessable();
            $response->assertJsonValidationErrors('file');
            $response->assertJsonStructure([
                'message',
                'errors' => [
                    'file'
                ]
            ]);
        });

        test('create a room with file upload', closure: function () {
            Storage::fake('public');
            $fakeFile = UploadedFile::fake()->image('room.png');

            $payload = [
                ...$this->payload,
                'file' => $fakeFile
            ];

            $response = $this->postJson(route('rooms.store'), $payload);
            $response->assertCreated();
            assertRoomResponse($response, $payload);

            expect($response->json('file_path'))->toBeString();

            Storage::disk('public')->assertExists($response->json('file_path'));
        });
    });

    describe('show', function () {
        it('return bad request when is not preset query string nick_name', function () {
            $room = Room::factory()->create();
            $response = $this->getJson(route("rooms.show", $room->code));
            $response->assertBadRequest();
        });
        test('return 404 when nick_name of user does exists in database', function () {
            $room = Room::factory()->create();
            $params = [
                'room' => $room->code,
                'nick_name' => 'not-exists-nick-name'
            ];
            $response = $this->getJson(
                route("rooms.show", $params)
            );
            $response->assertNotFound();
        });

        test('return a room', function () {
            $room = Room::factory()->create();
            $params = [
                'room' => $room->code,
                'nick_name' => $room->user->nick_name
            ];
            $response = $this->getJson(
                route("rooms.show", $params)
            );
            $response->assertOk();

            $response->assertJsonStructure([
                'id',
                'user_id',
                'name',
                'code',
                'file_path'
            ]);
        });
    });

    describe('delete', function () {
        it('return bad request when is not preset query string nick_name', function () {
            $room = Room::factory()->create();
            $response = $this->deleteJson(route("rooms.destroy", $room->id));
            $response->assertBadRequest();
        });

        test('return 404 when nick_name of user does exists in database', function () {
            $room = Room::factory()->create();
            $params = [
                'room' => $room->id,
                'nick_name' => 'not-exists-nick-name'
            ];
            $response = $this->deleteJson(
                route("rooms.destroy", $params)
            );
            $response->assertNotFound();
        });

        test('delete a room', function () {
            $room = Room::factory()->create();
            $params = [
                'room' => $room->id,
                'nick_name' => $room->user->nick_name
            ];
            $response = $this->deleteJson(
                route("rooms.destroy", $params)
            );
            $response->assertNoContent();

            expect(Room::find($room->id))->toBeNull();
        });
    });

});

function assertRoomResponse($response, $payload): void
{
    $response->assertJsonStructure([
        'id',
        'user_id',
        'name',
        'code',
        'file_path',
        'file_url',
    ]);

    $user = User::find($response->json('user_id'));

    expect($user->nick_name)->toBe($payload['nick_name']);
}
