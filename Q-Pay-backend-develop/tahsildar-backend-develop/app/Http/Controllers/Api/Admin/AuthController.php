<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    /** @var AuthService */
    protected AuthService $authService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login user into new session.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        return $this->handleSharedMessage(
            $this->authService->login(
                $request->post('username'),
                $request->post('password')
            )
        );
    }

    /**
     * Logout user from his session.
     *
     * @return JsonResponse
     */
    public function logout()
    {
        return $this->handleSharedMessage($this->authService->logout());
    }
}
