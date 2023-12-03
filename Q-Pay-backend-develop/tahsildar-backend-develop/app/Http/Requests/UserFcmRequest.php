<?php

namespace App\Http\Requests;

use App\Definitions\PlatformType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFcmRequest extends FormRequest
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
            'fcm_token' => ['required','string','max:255'],
            'fcm_platform' => ['required', Rule::in(PlatformType::TYPES)]
        ];
    }
}
