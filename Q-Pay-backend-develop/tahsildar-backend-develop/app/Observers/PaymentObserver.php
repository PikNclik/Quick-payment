<?php

namespace App\Observers;

use App\Definitions\PaymentStatus;
use App\Models\Payment;
use App\Services\Shared\NotificationService;
use Illuminate\Support\Facades\Http;

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

            $payment->load('user');
            $user_webhook_url = $payment->user->webhook_url;
            if ($user_webhook_url && $new_status == PaymentStatus::PAID)
                Http::post($user_webhook_url, [
                    'id' => $payment->id,
                    'amount' => $payment->amount,
                    'details' => $payment->details,
                ]);
            $title = "لديك اشعار جديد!";
            $body = "تم تحديث حالة الفاتورة #$payment->id";
            $user_id = $payment->user_id;
            $payload = ['payment_id' => $payment->id , 'image' => null];
            if ($user_id && in_array($new_status,PaymentStatus::NOTIFICATION_STATUSES))
                $this->notificationService->send($user_id,$title,$body,$payload);
        }
    }
}
