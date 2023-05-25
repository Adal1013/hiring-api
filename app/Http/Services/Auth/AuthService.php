<?php

namespace App\Http\Services\Auth;

use App\Http\DataTransferObjects\User\UserLoginData;

interface AuthService
{
    /**
     * @param UserLoginData $userLoginData
     * @return array
     */
    public function authenticate(UserLoginData $userLoginData): array;
}
