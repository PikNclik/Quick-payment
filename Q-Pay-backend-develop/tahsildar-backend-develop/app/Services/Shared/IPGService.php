<?php

namespace App\Services\Shared;

use App\Definitions\PaymentStatus;
use App\Jobs\SendSmsToPhone;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\Admin\TransactionToDoService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Http;

class IPGService
{
    public function __construct(private PaymentService $paymentService,
                                private TransactionToDoService $transactionToDoService)
    {
    }

    public function getToken(Payment $payment): string|null|int
    {
        $data = [
            'webhookUrl' => "https://api.piknclk.com/payment-callback",
            'successUrl' =>"https://api.piknclk.com/success-payment",
            'TerminalNumber' => env('PICKTERMINAL'),
            'reference' => (string) $payment->id,
            'amount' =>(string) ($payment->actual_payment + $payment->actual_fee),
            'AdditionalData' => 'Qpay',
            'phoneNumber' => '0'.$payment->customer->phone,

        ];
        $response = Http::withoutVerifying()->withHeaders([
            "Authorization"=>"Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwidXNlcm5hbWUiOiJ0ZXN0Iiwicm9sZSI6Im1lcmNoYW50IiwiaWF0IjoxNzI2NjYxODgyfQ.r4eapYXoivumnx55MaLtccko7iZc4i-ul3l6K5vSfIk",

        ])
            ->post("https://ipg-api.piknclk.com/api/merchant/payment",$data);
        return $response->json()['data']['id'];
    }

    public function callBack($payload)
    {
        $ref_num = $payload['RefNum'];
        $rrn = $payload['RRN'];
        $hash_card = $payload['HashCard'];
        $result = $payload['Result'];
        $id = $payload['TraceNo'];
        $iinNumber = $payload['IIN'];

        $payment = $this->paymentService->view($id)->data;
        if ($payment->status == PaymentStatus::PAID){
            return  false;
        }
        if ($result == 0) {
            $fixedCommission = Setting::getValue("commission_fixed") ?? 0;
            $percentageCommission = Setting::getValue("commission_percentage") ?? 0;
            if ($percentageCommission || $fixedCommission){
                $commission =  $fixedCommission + ($percentageCommission * $payment->amount);
                $actualCommission =  $fixedCommission + ($percentageCommission * $payment->actual_payment);
            }
            $payment = resolve(PaymentService::class)
                ->update(
                $payment->id,
                ['ref_num' => $ref_num, 'rrn' => $rrn, 'hash_card' => $hash_card,
                 'commission_percentage' => $percentageCommission,
                 'commission_value' => $commission ?? 0,
                 'actual_commission' => $actualCommission ?? 0,
                 'iin_number'=>$iinNumber
                ]
            )->data;
            $this->confirmPayment($payment);
            if ($payment->payment_type == 'FOLLOW-UP'){
                $this->paymentService->createFromPartPayment($payment);
            }
            $this->transactionToDoService->createToDoForPayment($payment->id);
            return true;
        }
        return false;
    }

    public function confirmPayment(Payment $payment)
    {
            if ($payment->user() != null) {
                SendSmsToPhone::dispatch($payment->user->removeCountryCode(), __('payment.payment_done_sms', ['amount' => $payment->actual_payment, 'phone' => $payment->customer->phone, 'uuid' => $payment->uuid], $payment->user->language));
            }
            $this->paymentService->update(
                $payment->id,
                ['status' => PaymentStatus::PAID]
            )->data;
    }
}
