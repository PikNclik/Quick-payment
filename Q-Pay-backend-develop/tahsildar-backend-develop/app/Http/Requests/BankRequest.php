<?php

namespace App\Http\Requests;

use App\Models\Bank;

class BankRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $model = Bank::where('id', $this->route('bank'))->first();
        if ($model)
            switch ($this->method()) {
                case 'GET':
                case 'POST':
                case 'PUT':
                case 'PATCH':
                case 'DELETE':
                    break;
            }
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
            return [
                'name_ar' => ['required', 'string', 'max:255'],
                'name_en' => ['required', 'string', 'max:255'],
            ];
            default:
                break;
        }
        return [];
    }
}