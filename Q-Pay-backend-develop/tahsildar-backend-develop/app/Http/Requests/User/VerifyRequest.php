<?php

namespace App\Http\Requests\User;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class VerifyRequest extends MainRequest
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
            'phone' => ['required', Rule::exists('users', 'phone')],
            'verification_code' => ['required', 'string', 'min:4', 'max:4']
        ];
    }
}
