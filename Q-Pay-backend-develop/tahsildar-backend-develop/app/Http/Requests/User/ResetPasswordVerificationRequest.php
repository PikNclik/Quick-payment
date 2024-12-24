<?php

namespace App\Http\Requests\User;

use App\Http\Requests\MainRequest;

class ResetPasswordVerificationRequest extends MainRequest
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
            'code' => ['required','min:4','max:4']
        ];
    }
}
