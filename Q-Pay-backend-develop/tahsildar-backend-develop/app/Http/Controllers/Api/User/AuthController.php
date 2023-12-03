<?php

namespace App\Http\Controllers\Api\User;



use App\Http\Controllers\BaseController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\VerifyRequest;
use App\Http\Requests\UserLogoutRequest;
use App\Services\User\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * User login
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->authService->login($request->validated()));
    }

    /**
     * Verify User login
     * @param VerifyRequest $request
     * @return JsonResponse
     */
    public function verifyUser(VerifyRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->authService->verifyUser($request->validated()));
    }

    /**
     * User logout
     * @param UserLogoutRequest $request
     * @return JsonResponse
     */
    public function logout(UserLogoutRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->authService->logout($request->validated()));
    }
}
