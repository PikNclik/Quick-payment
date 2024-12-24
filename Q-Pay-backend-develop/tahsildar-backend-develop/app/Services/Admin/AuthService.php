<?php

namespace App\Services\Admin;


use App\Common\SharedMessages\ApiSharedMessage;
use App\Models\Admin;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class AuthService
{
    /**
     * Create token for user.
     *
     * @param string $username
     * @param string $password
     * @return ApiSharedMessage
     */
    public function login(string $username, string $password): ApiSharedMessage
    {
        try {

            $user = Admin::where('username', $username)->first();
            if (!$user || !Hash::check($password, $user->password))
            {
                return new ApiSharedMessage(__('errors.wrong_email_or_password'), [], false, null, 401);
            }
            $timeout = 15 * 60;
            Cache::put('user-last-activity-' . $user->id, 1,$timeout);
            $data['user'] = $user ;

            $last_abilities = $user->tokens()->latest()->first() ?->abilities;
            $user->tokens()->delete();
            $personal_token = $user->createToken('user-auth-token',$last_abilities ?? ['admin']);
            $data['user']->accessToken = $personal_token->plainTextToken;
            $data['user']->permissions =  $user->role != null ?  $user->role->permissions: [];

            return new ApiSharedMessage(
                __('success.login', ['user' => $user->username]),
                $data,
                true,
                null,
                200);

        } catch (Exception $exception) {
            return new ApiSharedMessage(__('errors.general_error'),
                null,
                false,
                $exception->getMessage(),
                500);
        }
    }

    /**
     * Delete user existing token.
     *
     * @return ApiSharedMessage
     */
    public function logout(): ApiSharedMessage
    {
        try {
            auth()->user()->currentAccessToken()->delete();

            return new ApiSharedMessage(__('success.logout'),
                null,
                true,
                null,
                200
            );

        } catch (Exception $exception) {
            return new ApiSharedMessage(__('errors.general_error'),
                null,
                false,
                $exception->getMessage(),
                500
            );
        }
    }
}
