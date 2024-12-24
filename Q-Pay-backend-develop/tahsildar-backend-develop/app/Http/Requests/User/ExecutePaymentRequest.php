<?php

namespace App\Http\Requests\User;

use App\Definitions\PaymentStatus;
use App\Definitions\PaymentTypeEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ExecutePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        //        return request()->ip() == ;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'payment_id' => ['required', Rule::exists('payments', 'id')
                ->where('status', PaymentStatus::PENDING)
                ->where('user_id', Auth::id())
                ->where('type',PaymentTypeEnums::TRANSFER)
            ]
        ];
    }
}
