<?php

namespace App\Http\Services\Auth;

use App\Http\DataTransferObjects\User\UserLoginData;
use App\Http\Repositories\Auth\AuthRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthServiceImpl implements AuthService
{
    public function __construct(protected AuthRepository $authRepository)
    {
    }

    /**
     * @param UserLoginData $userLoginData
     * @return array
     */
    public function authenticate(UserLoginData $userLoginData): array
    {
        $token = $this->authRepository->getToken($userLoginData);

        if (empty($token)) {
            return [
                'success' => false,
                'errors' => ["Password incorrect for: {$userLoginData->username}"]
            ];
        }


        $minutesToExpire = JWTAuth::factory()->getTTL() * 60;

        return [
            'success' => true,
            'errors' => [],
            'token' => $token,
            'minutes_to_expire' => $minutesToExpire
        ];
    }
}
