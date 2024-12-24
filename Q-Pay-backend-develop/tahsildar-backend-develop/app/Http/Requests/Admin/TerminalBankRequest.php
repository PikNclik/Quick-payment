<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class TerminalBankRequest extends MainRequest
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
        return match ($this->method()) {
            "POST","PUT", "PATCH" => [
                'bank_id' => ['required', Rule::exists('banks', 'id')],
                'bank_account_number' => ['required', 'string', 'max:255'],
                'terminal' => ['required'],
                'active' => ['required', 'boolean']
                
            ],
            default => [],
        };
    }
}
