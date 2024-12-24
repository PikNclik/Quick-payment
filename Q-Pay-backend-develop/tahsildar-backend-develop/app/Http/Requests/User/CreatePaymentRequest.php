<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return request()->ip() == ;
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
            'bank_id' => ['required',Rule::exists('banks','id')->where('active',true)],
            'bank_account_number' => ['required','string','max:255'],
            'amount' => ['required','numeric','min:1'],
            'phone' => ['required','string','max:255'],
            'name' => ['required','string','max:255'],
        ];
    }
}
