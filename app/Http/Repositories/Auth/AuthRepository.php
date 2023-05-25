<?php

namespace App\Http\Repositories\Auth;

use App\Http\DataTransferObjects\User\UserLoginData;

interface AuthRepository
{
    /**
     * @param UserLoginData $userLoginData
     * @return string|null
     */
    public function getToken(UserLoginData $userLoginData): string|null;
}
