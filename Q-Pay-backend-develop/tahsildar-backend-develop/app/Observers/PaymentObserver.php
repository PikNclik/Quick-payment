<?php

namespace App\Observers;

use App\Definitions\PaymentStatus;
use App\Models\Payment;
use App\Services\Shared\NotificationService;

class PaymentObserver
{
    private NotificationService $notificationService;


    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param Payment $payment
     * @return void
     */
    public function updating(Payment $payment): void
    {
        if($payment->isDirty('status')){
            // status has changed
            $new_status = $payment->status;
            $old_status = $payment->getOriginal('status');

            $title = "Payment With Invoice Num #$payment->id Status has updated";
            $body = "Payment With Invoice Num #$payment->id Status has updated";
            $user_id = $payment->user_id;
            $payload = ['payment_id' => $payment->id , 'image' => null];
            if (in_array($new_status,PaymentStatus::NOTIFICATION_STATUSES))
                $this->notificationService->send($user_id,$title,$body,$payload);
        }
    }
}
