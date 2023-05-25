<?php

namespace Tests\Unit\Services;

use App\Http\DataTransferObjects\User\UserLoginData;
use App\Http\Services\Auth\AuthService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RoleTableSeeder;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $authService;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->authService = app(AuthService::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_token()
    {
        $this->seed(RoleTableSeeder::class);
        $user = User::factory()->create();
        $credentials = [
            'username' => $user->username,
            'password' => 'hiring'
        ];
        $data = $this->authService->authenticate(UserLoginData::from($credentials));
        $this->assertIsArray($data);
        $this->assertArrayHasKey('success', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('token', $data);
        $this->assertArrayHasKey('minutes_to_expire', $data);
        $this->assertIsBool($data['success']);
        $this->assertIsArray($data['errors']);
        $this->assertIsString($data['token']);
        $this->assertNotEmpty($data['token']);
    }
}
