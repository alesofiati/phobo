<?php

use App\Models\User;

describe('crud users', function (){
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
    test('should return 201 when create a new user', function () {

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
