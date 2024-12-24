<?php

namespace App\Http\Requests;

use App\Definitions\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PickRequest extends FormRequest
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
        return [
            'RefNum' => ['required', 'string'],
            'RRN' => ['required', 'string'],
            'IIN' => ['required', 'string'],
            'HashCard' => ['required', 'string'],
            'TerminalNumber' => ['required', 'string', Rule::in([env('PICKTERMINAL')])], // todo review.
            'Result' => ['required', 'string'],
            'TraceNo' => ['required', Rule::exists('payments', 'id')->where('status', PaymentStatus::PENDING)],
        ];
    }

    protected function getRedirectUrl(): string
    {
        return route('payment.error');
    }

}
