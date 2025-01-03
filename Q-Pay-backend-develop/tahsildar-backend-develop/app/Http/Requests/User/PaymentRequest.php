<?php

namespace App\Http\Requests\User;

use App\Http\Requests\MainRequest;
use App\Models\Payment;
use Illuminate\Validation\Rule;

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
                    'payer_name' => ['required_without:qpay_id','string','max:255'],
                    'payer_mobile_number' => ['required_without:qpay_id','string','max:255'],
                    'qpay_id' => ['sometimes','string',Rule::exists('users','qpay_id')],
                    'amount' => ['required','numeric'],
                    'details' => ['nullable','string','Max:255'],
                    'payment_type' => 'nullable|in:NORMAL,PARTIAL,FOLLOW-UP',
                    'min_part_limit' => 'nullable|integer',
                    'scheduled_date' => 'nullable|Date|after:' . date('Y-m-d'),
                    'merchant_reference' => 'nullable',

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
