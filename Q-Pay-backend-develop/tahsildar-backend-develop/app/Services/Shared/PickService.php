<?php

namespace App\Services\Shared;

use App\Definitions\CommissionTypes;
use App\Definitions\PaymentStatus;
use App\Definitions\PaymentTypeEnums;
use App\Jobs\SendSmsToPhone;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\Admin\TransactionToDoService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Http;

class PickService
{
    public function __construct(
        private PaymentService $paymentService,
        private TransactionToDoService $transactionToDoService
    ) {}

    /**
     * @param Payment $payment
     * @return string|int|null
     */
    public function getToken(Payment $payment): string|null|int
    {
        $data = [
            'AppUser' => env('PICKUSERNAME'),
            'AppPassword' => env('PICKPASSWORD'),
            'callBackUrl' => route('payment.callback'),
            'TerminalNumber' => env('PICKTERMINAL'),
            'ReservationNumber' => $payment->id,
            'Amount' => $payment->actual_payment + $payment->actual_fee,
            'AdditionalData' => 'Tahsildar',
            'cellNo' => '0' . $payment->customer->phone,

        ];
        $response = Http::withoutVerifying()
            ->post(env('PICKURL') . '/MerchantServicesRest/api/Sale/RequestToken', $data);

        return $response->json()['Token'];
    }


    public function callBack($payload)
    {
        $ref_num = $payload['RefNum'];
        $rrn = $payload['RRN'];
        $hash_card = $payload['HashCard'];
        $result = $payload['Result'];
        $id = $payload['TraceNo'];

        $payment = $this->paymentService->view($id)->data;
        if ($payment->status == PaymentStatus::PAID) {
            return  false;
        }
        if ($result == 0) {

            if ($payment->type == PaymentTypeEnums::PAYMENT)
                $relation = 'user';
            else if ($payment->type == PaymentTypeEnums::TRANSFER)
                $relation = 'customer';
            $to_bank_id = $payment->{$relation}->bank_id;
            $from_bank_id = $payment->terminal_bank->bank_id;
            if ($from_bank_id == $to_bank_id)
                $commissionScheme = $payment->terminal_bank->internal_commission;
            else
                $commissionScheme = $payment->terminal_bank->external_commission;
            if ($commissionScheme != null && $commissionScheme->type != CommissionTypes::IGNORE) {
                $commission =  $commissionScheme->commission_fixed + (($commissionScheme->commission_percentage * $payment->amount)/100);
                if ($commission < $commissionScheme->min)
                    $commission = $commissionScheme->min;
                else if ($commission > $commissionScheme->max)
                    $commission = $commissionScheme->max;
                $actualCommission =  $commissionScheme->commission_fixed + (($commissionScheme->commission_percentage * $payment->actual_payment)/100);
                if ($actualCommission < $commissionScheme->min)
                    $actualCommission = $commissionScheme->min;
                else if ($actualCommission > $commissionScheme->max)
                    $actualCommission = $commissionScheme->max;
            }
            $payment = resolve(PaymentService::class)
                ->update(
                    $payment->id,
                    [
                        'ref_num' => $ref_num,
                        'rrn' => $rrn,
                        'hash_card' => $hash_card,
                        'commission_percentage' => $commissionScheme->type != CommissionTypes::IGNORE ? $commissionScheme->commission_percentage: 0,
                        'commission_value' => $commission ?? 0,
                        'actual_commission' => $actualCommission ?? 0
                    ]
                )->data;

            $result = $this->confirmPayment($payment);
            if ($result) {
                if ($payment->payment_type == 'FOLLOW-UP') {
                    $this->paymentService->createFromPartPayment($payment);
                }
                $this->transactionToDoService->createToDoForPayment($payment->id);
                return true;
            }
            return false;
        }
        return false;
    }

    public function confirmPayment(Payment $payment): bool
    {
        $data = [
            'AppUser' => env('PICKUSERNAME'),
            'AppPassword' => env('PICKPASSWORD'),
            'TerminalNumber' => env('PICKTERMINAL'), // todo review all used env
            'ReservationNumber' => $payment->id,
            'Amount' => $payment->actual_payment + $payment->actual_fee,
            'AdditionalData' => 'Tahsildar',
            'Token' => $payment->token,
            'RefNum' => $payment->ref_num
        ];

        $response = Http::withoutVerifying()
            ->post(env('PICKURL') . '/MerchantServicesRest/api/Sale/ConfirmTransaction', $data);

        $result = $response->json()['Result'] == 0;
        if ($result) {
            if ($payment->user() != null) {
                SendSmsToPhone::dispatch($payment->user->removeCountryCode(), __('payment.payment_done_sms', ['amount' => $payment->actual_payment, 'phone' => $payment->customer->phone, 'uuid' => $payment->uuid], $payment->user->language));
            }
            $this->paymentService->update(
                $payment->id,
                ['status' => PaymentStatus::PAID]
            )->data;
        }


        return $result;
    }

    public function reversePayment(Payment $payment)
    {
        $data = [
            'AppUser' => env('PICKUSERNAME'),
            'AppPassword' => env('PICKPASSWORD'),
            'TerminalNumber' => env('PICKTERMINAL'),
            'ReservationNumber' => $payment->id,
            'Amount' => $payment->amount + $payment->fees_value,
            'AdditionalData' => 'Tahsildar',
            'Token' => $payment->token,
            'RefNum' => $payment->ref_num
        ];

        $response = Http::withoutVerifying()
            ->post(env('PICKURL') . '/MerchantServicesRest/api/Sale/ReverseTransaction', $data);

        return $response->json()['Result'];
    }
}
