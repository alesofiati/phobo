<?php

use App\Models\User;

describe('crud users', function () {
    it('should return 422 when nick_name is empty', function () {
        $response = $this->postJson('/api/users', []);
        $response->assertExactJsonStructure([
            'message',
            'errors' => [
                'nick_name'
            ]
        ]);
        $response->assertJsonValidationErrors('nick_name');
        $response->assertStatus(422);
    });
    it('should return 422 when nick_name is present in database', function () {

        $user = User::factory()->create();

        $response = $this->postJson('/api/users', [
            'nick_name' => $user->nick_name
        ]);
        $response->assertExactJsonStructure([
            'message',
            'errors' => [
                'nick_name'
            ]
        ]);
        $response->assertJsonValidationErrors('nick_name');
        $response->assertStatus(422);

    });
    test('return 201 when create a new user', function () {

        $payload = [
            'nick_name' => 'test'
        ];

        $response = $this->postJson('/api/users', $payload);
        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'nick_name'
        ]);
        $this->assertDatabaseHas('users', $payload);
    });
});
describe('verify if nick_name already exists in database', function () {
    test('return 200 when nick_name does exist in database', function () {
        $response = $this->postJson('/api/users/verify', [
            'nick_name' => Str::slug(fake()->unique()->name)
        ]);
        $response->assertOk();
        $response->assertExactJsonStructure(['message']);
        $this->assertEquals(trans('messages.nick_name_available'), $response->json('message'));
    });
    test('return 409 when nick_name exist in database', function () {
        $user = User::factory()->create();
        $response = $this->postJson('/api/users/verify', [
            'nick_name' => $user->nick_name
        ]);
        $response->assertConflict();
        $response->assertExactJsonStructure(['message']);
        $this->assertEquals(trans('messages.nick_name_already_exists'), $response->json('message'));
    });
});
