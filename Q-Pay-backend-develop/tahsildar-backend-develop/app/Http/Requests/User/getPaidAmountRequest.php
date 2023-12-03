<?php

namespace App\Http\Requests\User;

use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;

class getPaidAmountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $model = Payment::where('id', $this->route('payment'))->first();
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
                return[
                    'month' => ['required', 'string', 'size:2', 'between:01,12'],
                    'year' => ['required', 'string', 'size:4'],
                ];
            case 'PATCH':
            case 'DELETE':
            case 'PUT':
            case 'POST':
            default:
                break;
        }
        return [];
    }
}
