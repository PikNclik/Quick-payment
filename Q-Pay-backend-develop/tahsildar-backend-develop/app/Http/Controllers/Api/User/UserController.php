<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\UserFcmRequest;
use App\Http\Requests\UserLanguageRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseCrudController
{

    protected string $request = UserRequest::class;

    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }

    public function updateProfile(): JsonResponse
    {
        $request = resolve($this->request);
        $id = Auth::id();
        $this->service->update($id, $request->validated());
        return $this->handleSharedMessage($this->service->view($id, ['*'], ['bank','city','media']));
    }

    public function updateFcm(UserFcmRequest $request ): JsonResponse
    {
        $id = Auth::id();
        return $this->handleSharedMessage($this->service->update($id, $request->validated()));
    }

    public function deleteFcm(): JsonResponse
    {
        $id = Auth::id();
        $payload = ['fcm_token' => null, 'fcm_platform' => null];
        return $this->handleSharedMessage($this->service->update($id, $payload));
    }

    public function show(int $id)
    {
        return $this->handleSharedMessage($this->service->view($id,['*'],['bank','city','media']));
    }

    public function updateLanguage(UserLanguageRequest $request ): JsonResponse
    {
        $id = Auth::id();
        return $this->handleSharedMessage($this->service->update($id, $request->validated()));
    }
}
