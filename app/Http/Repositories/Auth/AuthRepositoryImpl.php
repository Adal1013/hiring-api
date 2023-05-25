<?php

namespace App\Http\Repositories\Auth;

use App\Http\DataTransferObjects\User\UserLoginData;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepositoryImpl implements AuthRepository
{
    /**
     * @param UserLoginData $userLoginData
     * @return string|null
     */
    public function getToken(UserLoginData $userLoginData): string|null
    {
        return JWTAuth::attempt($userLoginData->toArray());
    }
}
