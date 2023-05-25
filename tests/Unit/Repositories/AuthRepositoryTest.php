<?php

namespace Tests\Unit\Repositories;

use App\Http\DataTransferObjects\User\UserLoginData;
use App\Http\Repositories\Auth\AuthRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RoleTableSeeder;

class AuthRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected AuthRepository $authRepository;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->authRepository = app(AuthRepository::class);
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
        $token = $this->authRepository->getToken(UserLoginData::from($credentials));
        $this->assertIsString($token);
        $this->assertNotEmpty($token);
    }
}
