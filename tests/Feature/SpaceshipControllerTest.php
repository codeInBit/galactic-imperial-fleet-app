<?php

namespace Tests\Feature;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Spaceship;
use App\Models\User;
use Tests\TestCase;

class SpaceshipControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $user;

    public function testGetAllSpaceships()
    {
        $this->withExceptionHandling();
        $response = $this->getJson('/api/spaceships');

        $response->assertStatus(200)
        ->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'status',
                    ],
                ]
            ]
        );
    }

    public function testCreateSpaceshipWithoutAuthentication()
    {
        $this->withExceptionHandling();

        $response = $this->postJson('/api/spaceships', [
            "name" => 'Devastator',
            "class" => 'Star Destroyer',
            "crew" => 35000,
            "image" => 'https://url.to.image',
            "value" => 1999.99,
            "status" => 'operational',
            "armament" => [
                [
                    "title" => 'Star Destroyer',
                    "qty" => 35
                ]
            ]
        ]);

        $response->assertStatus(401)
        ->assertJson(
            [
                "success" => false,
                "message" => "Unauthenticated.",
            ]
        );
    }

    public function testCreateSpaceship()
    {
        /**
         * @var Authenticatable
         */
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $this->withoutExceptionHandling();

        $response = $this->postJson('/api/spaceships', [
            "name" => 'Devastator',
            "class" => 'Star Destroyer',
            "crew" => 35000,
            "image" => 'https://url.to.image',
            "value" => 1999.99,
            "status" => 'operational',
            "armament" => [
                [
                    "title" => 'Star Destroyer',
                    "qty" => 35
                ]
            ]
        ]);

        $response->assertStatus(201)
        ->assertJsonStructure(['success']);
    }

    public function testCreateSpaceshipWithoutARequiredParameter()
    {
        /**
         * @var Authenticatable
         */
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $this->withExceptionHandling();

        $response = $this->postJson('/api/spaceships', [
            "name" => 'Devastator',
            "class" => 'Star Destroyer',
            "crew" => 35000,
            "image" => 'https:\\url.to.image',
            "value" => 1999.99,
            "armament" => [
                "title" => 'Star Destroyer',
                "qty" => '35',
            ]
        ]);

        $response->assertStatus(422)
        ->assertJsonStructure(
            [
                'message',
                'errors' => [
                    'status'
                ]
            ]
        );
    }

    public function testShowASpaceship()
    {
        $this->withExceptionHandling();

        $spaceship = Spaceship::factory()->create();
        $response = $this->getJson("/api/spaceships/" . $spaceship['id']);
        $response->assertStatus(200)
        ->assertJsonStructure(
            [
                'id',
                'name',
                'class',
                'crew',
                'image',
                'value',
                'status',
                'armament' => [
                    '*' => [
                        'title',
                        'qty',
                    ],
                ]
            ]
        );
    }

    public function testUpdateASpaceship()
    {
        $this->withExceptionHandling();

        /**
         * @var Authenticatable
         */
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $spaceship = Spaceship::factory()->create();
        $response = $this->putJson("/api/spaceships/" . $spaceship['id'], [
            "name" => 'Devastator',
            "class" => 'Star Destroyer',
            "crew" => 35000,
            "image" => 'https://url.to.image',
            "value" => 1999.99,
            "status" => 'operational',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'success'
            ]
        );
    }

    public function testDeleteASpaceship()
    {
        $this->withExceptionHandling();

        /**
         * @var Authenticatable
         */
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $spaceship = Spaceship::factory()->create();
        $response = $this->deleteJson("/api/spaceships/" . $spaceship['id']);

        $response->assertStatus(204);
    }
}
