<?php

namespace App\Http\Controllers\Api\User;



use App\Http\Controllers\BaseController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\ResetPasswordRequestRequest;
use App\Http\Requests\User\ResetPasswordVerificationRequest;
use App\Http\Requests\User\UserLoginRequest;
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
     * Verify User login
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function loginPassword(UserLoginRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->authService->loginPassword($request->validated()));
    }

    /**
     * reset password request
     * @param ResetPasswordRequestRequest $request
     * @return JsonResponse
     */
    public function resetPasswordRequest(ResetPasswordRequestRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->authService->resetPasswordRequest($request->validated()));
    }

    /**
     * reset password verification
     * @param ResetPasswordVerificationRequest $request
     * @return JsonResponse
     */
    public function resetPasswordVerification(ResetPasswordVerificationRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->authService->resetPasswordVerification($request->validated()));
    }

    /**
     * reset password
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->authService->resetPassword($request->validated()));
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
