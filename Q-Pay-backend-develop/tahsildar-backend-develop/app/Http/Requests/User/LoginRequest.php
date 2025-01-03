<?php

namespace App\Http\Requests\User;

use App\Http\Requests\MainRequest;

class LoginRequest extends MainRequest
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
    public function rules()
    {
        return [
            'phone' => ['required','string'],
            'send' => ['required','boolean']
        ];
    }
}
