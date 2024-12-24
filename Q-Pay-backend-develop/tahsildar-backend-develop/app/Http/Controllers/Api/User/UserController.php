<?php

namespace App\Http\Controllers\Api\User;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\UserFcmRequest;
use App\Http\Requests\UserLanguageRequest;
use App\Mail\NewUserMail;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        $payload = $request->validated();
        $user = User::find($id);
        $isFirstTime = $user->full_name == null;
        $this->service->update($id,$payload );
        if ($isFirstTime){
            $recipientEmail = 'Info@piknclk.com';
            Mail::to($recipientEmail)->send(new NewUserMail($user));
        }
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

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->handleSharedMessage(
                new ApiSharedMessage(__('errors.wrong_old_password'), [], false, null, 400)
            );
        }
        return $this->handleSharedMessage($this->service->update($user->id,['password' => $request->new_password]));
    }
}
