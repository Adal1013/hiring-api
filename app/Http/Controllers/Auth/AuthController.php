<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\User\UserLoginData;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Services\Auth\AuthService;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * Login to the application with a valid username.
     * Accede a la aplicación con un usuario valido.
     * @param LoginRequest $request
     * @return AuthResource
     *
     * @OA\Post(
     *     path="/api/v1/auth",
     *     tags={"Authentication"},
     *     summary="Genera un token de autenticación",
     *     operationId="login",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             required={"username", "password"},
     *             @OA\Property(property="username", type="string", example="adal123"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Token generado exitosamente."),
     *     @OA\Response(response="401", description="Unauthorized."),
     *     @OA\Response(response="500", description="Server error.")
     * )
     */
    public function login(LoginRequest $request)
    {
        return new AuthResource($this->authService->authenticate(UserLoginData::from($request)));
    }
}
