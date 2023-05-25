<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\User\UserLoginData;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Services\Auth\AuthService;

class AuthController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @param LoginRequest $request
     * @return AuthResource
     */
    public function login(LoginRequest $request)
    {
        return new AuthResource($this->authService->authenticate(UserLoginData::from($request)));
    }
}
