<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class TerminalBankCommissionRequest extends MainRequest
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
           
            "POST" => [
                    'commission_percentage' => ['required','numeric','min:0', 'max:100'],
                    'commission_fixed' => ['required','numeric','min:0'],
                    'min' => ['required','numeric','min:0'],
                    'max' => ['required','numeric','min:0'],
                    'bank_account_number' => ['required', 'string', 'max:255'],
                    'type' => ['required','in:direct,indirect,ignore']                
            ],
            default => [],
        };
    }
}
