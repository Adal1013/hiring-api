<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RoleTableSeeder;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $this->seed(RoleTableSeeder::class);
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'hiring'
        ];
        $response = $this->post('api/v1/auth', $credentials);
        $response->assertStatus(200);
        $response->assertJson([
            'meta' => [
                'success' => true,
                'errors' => []
            ],
            'data' => [
                'token' => true,
                'minutes_to_expire' => 3600
            ]
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_failed()
    {
        $credentials = [
            'username' => 'notExists',
            'password' => 'notExists'
        ];
        $response = $this->post('api/v1/auth', $credentials);
        $response->assertStatus(401);
        $response->assertJson([
            'meta' => [
                'success' => false,
                'errors' => ['Password incorrect for: notExists']
            ]
        ]);
    }
}
