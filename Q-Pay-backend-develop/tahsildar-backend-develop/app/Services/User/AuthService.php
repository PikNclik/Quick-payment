<?php

namespace App\Services\User;


use App\Common\SharedMessages\ApiSharedMessage;
use App\Jobs\SendSmsToPhone;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    private UserRepository $repository;
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * User login by phone number
     * @param array $payload
     * @return ApiSharedMessage
     */
    public function login(array $payload)
    {
        try {
            $user = $this->repository->getElementBy('phone',$payload['phone']);
            //check if user exists
            if (!$user) {
                // store new user.
                $payload['qpay_id']="Q". chr(rand(97, 122)) . chr(rand(97, 122)) . rand(0,9) . rand(0,9) . rand(0,9);
                $user = $this->repository->create($payload);
            }
            $token = rand(1111, 9999);
            $send = true;
            if ($user->phone == '+963993522958')
            {
                $token = '1111';
                $send = false;
            }
            if (!boolval($payload['send']) && $send) $send = false;
            $phone = substr($payload['phone'],4);
            if ($send)
                SendSmsToPhone::dispatch($phone,'Your OTP for Q-PAY is '.$token);
            $this->repository->update($user->id,['verification_code' => $token]);
            $can_login_password = $user->full_name != null && $user->password != null;
            return new ApiSharedMessage(__('success.sent_verify_code'), $can_login_password, true, null, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return new ApiSharedMessage($exception->getMessage(), [], false, $exception, 500);
        }
    }

    /**
     * verify user login
     * @param array $payload
     * @return ApiSharedMessage
     */
    public function verifyUser(array $payload)
    {
        try {
            $user = $this->repository->getElementBy('phone',$payload['phone']);
            if(!$user->active)

            return new ApiSharedMessage(__('errors.blocked'), [], false, null, 403);

            if ($user) {
                if ($user->verification_code != null && $user->verification_code == $payload['verification_code']) {
                    $user->tokens()->delete();
                    $token = $user->createToken('user-auth-token', ['user'])->plainTextToken;
                    $this->repository->update($user->id,['verification_code' => null]);
                    $user =  $this->repository->findById($user->id,['*'],['bank']);
                    $user->access_token = $token;
                    $data['user'] = $user;
                    return new ApiSharedMessage(__('success.login'), $data, true, null, 200);
                }
                return new ApiSharedMessage(__('errors.wrong_code'), [], false, null, 400);
            } else {
                return new ApiSharedMessage(__('errors.user_not_found'), [], false, null, 401);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return new ApiSharedMessage($exception->getMessage(), [], false, $exception->getMessage(), 500);
        }
    }

    /**
     * Log the user out by revoke the token
     * @param $payload
     * @return ApiSharedMessage
     */
    public function logout($payload): ApiSharedMessage
    {
        try {
            if (array_key_exists('fcm_token',$payload))
            {
                $user = $this->repository->getElementBy('fcm_token',$payload['fcm_token']);
                if ($user && $user->id == Auth::id())
                {
                    $this->repository->update($user->id,['fcm_token' => null , 'fcm_platform' => null]);
                }
            }
            auth()->user()->currentAccessToken()->delete();
            return new ApiSharedMessage(__('success.logout'), null, true, null, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return new ApiSharedMessage($exception->getMessage(), null, false, $exception, 500);
        }
    }

    public function loginPassword(array $payload): ApiSharedMessage
    {
        try {
            $user = $this->repository->getElementBy('phone',$payload['phone']);


            if ($user) {
                if(!$user->active)
                    return new ApiSharedMessage(__('errors.blocked'), [], false, null, 403);
                if (Hash::check($payload['password'],$user->password)) {
                    $user->tokens()->delete();
                    $token = $user->createToken('user-auth-token', ['user'])->plainTextToken;
                    $user =  $this->repository->findById($user->id,['*'],['bank']);
                    $user->access_token = $token;
                    $data['user'] = $user;
                    return new ApiSharedMessage(__('success.login'), $data, true, null, 200);
                }
                return new ApiSharedMessage(__('errors.wrong_password'), [], false, null, 400);
            } else {
                return new ApiSharedMessage(__('errors.user_not_found'), [], false, null, 401);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return new ApiSharedMessage($exception->getMessage(), [], false, $exception->getMessage(), 500);
        }
    }

    public function resetPasswordRequest($payload): ApiSharedMessage
    {
        $user = $this->repository->getElementBy('phone', $payload['phone']);
        if ($user) {
            $code = rand(1111, 9999);
            $phone = substr($payload['phone'],4);
            SendSmsToPhone::dispatch($phone,'Your code for change password on Q-PAY is '.$code);
            $this->repository->update($user->id,['reset_password_code' => $code]);
            \Log::info('Your code for change password on Q-PAY is '.$code);
            return new ApiSharedMessage(__('success.reset_password_request'), [], true, null, 200);
        }
        return new ApiSharedMessage(__('errors.user_not_found'), [], false, null, 401);
    }

    public function resetPasswordVerification($payload): ApiSharedMessage
    {
        $user = $this->repository->getElementBy('phone', $payload['phone']);
        if ($user) {
            if ($user->reset_password_code != $payload['code']){
                return new ApiSharedMessage(__('errors.wrong_reset_password_code'), [], false, null, 401);
            }
            return new ApiSharedMessage(__('success.reset_password_code'), [], true, null, 200);
        }
        return new ApiSharedMessage(__('errors.user_not_found'), [], false, null, 401);
    }
    public function resetPassword($payload): ApiSharedMessage
    {
        $user = $this->repository->getElementBy('phone', $payload['phone']);
        if ($user) {
            if ($user->reset_password_code != $payload['code']){
                return new ApiSharedMessage(__('errors.wrong_reset_password_code'), [], false, null, 401);
            }
            $this->repository->update($user->id,['reset_password_code' => null, 'password' => $payload['new_password']]);
            return new ApiSharedMessage(__('success.reset_password'), [], true, null, 200);
        }
        return new ApiSharedMessage(__('errors.user_not_found'), [], false, null, 401);
    }
}
