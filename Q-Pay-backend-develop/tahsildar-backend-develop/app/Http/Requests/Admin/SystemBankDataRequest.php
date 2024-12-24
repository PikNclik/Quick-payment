<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MainRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SystemBankDataRequest extends MainRequest
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
        return match ($this->method()) {
            "PUT", "PATCH" => [
                'bank_account_number' => ['required', 'string', 'max:255','confirmed'],
                'default_transaction' => ['required','boolean']
            ],
            "POST" => [
                'bank_account_number' => ['required', 'string', 'max:255','confirmed'],
                'bank_id' => ['required',Rule::exists('banks','id')],
                'default_transaction' => ['required','boolean']
            ],
            default => [],
        };
    }
}
