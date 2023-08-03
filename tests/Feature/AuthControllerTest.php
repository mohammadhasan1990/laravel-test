<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_register_returns_a_successful_response()
    {
        $response = $this->postJson('/api/register', [
            'name'                  => 'test-user',
            'email'                 => fake()->email,
            'password'              => 123456,
            'password_confirmation' => 123456,
        ]);

        $response->assertStatus(201);
    }

    public function test_register_returns_a_validation_error_response()
    {
        $email = 'mohmhasan@gmail.com';

        User::query()->firstOrCreate([
            'email' => $email
        ], [
            'name' => 'Hasan',
            'password' => bcrypt(123456)
        ]);

        $response = $this->postJson('/api/register', [
            'name'                  => 'test-user',
            'email'                 => $email,
            'password'              => 123456,
            'password_confirmation' => 123456,
        ]);

        $response->assertStatus(422);
    }

    public function test_login_returns_a_successful_response()
    {
        $response = $this->postJson('/api/login', [
            'email'    => 'test-mail@gmail.com',
            'password' => 123456,
        ]);

        $response->assertStatus(200);
    }
}
