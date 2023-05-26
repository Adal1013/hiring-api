<?php

namespace App\Http\Repositories\Auth;

use App\Http\DataTransferObjects\User\UserLoginData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepositoryImpl implements AuthRepository
{
    /**
     * @param UserLoginData $userLoginData
     * @return string|null
     */
    public function getToken(UserLoginData $userLoginData): string|null
    {
        $token = JWTAuth::attempt($userLoginData->toArray());
        if (!empty($token)) {
            $user = Auth::user();
            $user->last_login = Carbon::now();
            $user->save();
        }
        return $token;
    }
}
