<?php

namespace App\Http\Requests\User;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class UserLoginRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required'],
            'password' => ['required','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/']
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => __('errors.new_password_regex')
        ];
    }
}
