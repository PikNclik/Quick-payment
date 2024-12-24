<?php

namespace App\Http\Requests\User;

use App\Http\Requests\MainRequest;

class ResetPasswordRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'phone' => ['required','string'],
            'code' => ['required','min:4','max:4'],
            'new_password' => 'required|min:8|different:old_password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'confirm_password' => 'required|same:new_password',
        ];
    }

    public function messages(): array
    {
        return [
            'new_password.regex' => __('errors.new_password_regex')
        ];
    }
}
