<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testLoginFailedDueToValidationErrors()
    {
        $this->json('POST', 'api/v1/login', [
            'email' => 'wrong_email',
        ])->assertInvalid(['email', 'password']);

        $this->json('POST', 'api/v1/login', [
            'email' => 'sethphat@google.com',
        ])->assertInvalid(['password']);
    }

    public function testLoginFailedDueToUserNotExists()
    {
        $this->json('POST', 'api/v1/login', [
            'email' => 'sethphat@google.com',
            'password' => '123456789',
        ])->assertStatus(400);
    }

    public function testLoginSuccessfully()
    {
        $user = User::factory()->create();

        $this->json('POST', 'api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
        ->assertOk()
        ->assertJsonStructure([
            'access_token',
            'user' => [
                'uuid',
                'name',
                'email'
            ],
        ])
        ->assertJsonFragment([
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testLogoutSuccessfully()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->json('POST', 'api/v1/logout')->assertOk();

        $this->assertEquals(0, $user->tokens()->count());
    }
}
