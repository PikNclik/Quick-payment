<?php

namespace App\Http\Requests\User;

use App\Http\Requests\MainRequest;
use App\Models\Payment;

class PaymentRequest extends MainRequest
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
        $scheduled_date = $this->request->get('scheduled_date');
        switch ($this->method()) {
            case 'GET':
                return[];
            case 'PATCH':
            case 'DELETE':
            case 'PUT':
            case 'POST':
                $rules =  [
                    'payer_name' => ['required','string','max:255'],
                    'payer_mobile_number' => ['required','string','max:255'],
                    'amount' => ['required','numeric'],
                    'details' => ['required','string','Max:255'],
                    'scheduled_date' => 'nullable|Date|after:' . date('Y-m-d')
                ];
            $scheduled_date ?
                $rules['expiry_date'] = 'nullable|Date|after:' . $scheduled_date
                : $rules['expiry_date'] = 'nullable|Date|after:' . date('Y-m-d');

                return $rules;
            default:
                break;
        }
        return [];
    }
}
