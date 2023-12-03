<?php

namespace App\Services\Admin;


use App\Common\SharedMessages\ApiSharedMessage;
use App\Models\Admin;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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
            $data['user'] = $user ;

            $data['user']->accessToken = $user->createToken('user-auth-token', ['admin'])->plainTextToken;

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
