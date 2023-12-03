<?php

namespace App\Services\Shared;

use App\Definitions\PaymentStatus;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Http;

class PickService
{
    public function __construct(private PaymentService $paymentService)
    {
    }

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
            'Amount' => $payment->amount + $payment->fees_value,
            'AdditionalData' => 'Tahsildar',
            'cellNo' => '0930619284',

        ];
         $response = Http::withoutVerifying()
             ->post(env('PICKURL').'/MerchantServicesRest/api/Sale/RequestToken',$data);

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

        if ($result == 0) {
            return $this->paymentService->update(
                $payment->id,
                ['ref_num' => $ref_num, 'rrn' => $rrn, 'hash_card' => $hash_card]
            )->data;
        }
        return false;
    }

    public function confirmPayment(Payment $payment)
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
            ->post(env('PICKURL').'/MerchantServicesRest/api/Sale/ConfirmTransaction',$data);

        return $response->json()['Result'];

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
            ->post(env('PICKURL').'/MerchantServicesRest/api/Sale/ReverseTransaction',$data);

        return $response->json()['Result'];
    }
}
