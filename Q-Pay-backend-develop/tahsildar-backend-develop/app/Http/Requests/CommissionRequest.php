<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

class CommissionRequest extends MainRequest
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
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'PATCH':
            case 'DELETE':
                return [];
            case 'PUT':
            case 'POST':
                return[
                    'terminal_bank_id' => ['required', Rule::exists('terminal_banks', 'id')],
                    'commission_percentage' => ['required','numeric','min:0', 'max:100'],
                    'commission_fixed' => ['required','numeric','min:0'],
                    'min' => ['required','numeric','min:0'],
                    'max' => ['required','numeric','min:0'],
                    'bank_account_number' => ['required', 'string', 'max:255'],
                    'type' => ['required','in:direct,indirect,ignore']

                ];
            default:
                break;
        }
        return [];
    }
}
