<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    public function testMustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    public function testSuccessfulLogin()
    {
        $user = User::factory()->create();
        $loginData = ['email' => 'abc@test.com', 'password' => 'password'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
               "user" => [
                   'name',
                   'email'
               ],
                "type",
                "token"
            ]);

        $this->assertAuthenticated();
    }
}
