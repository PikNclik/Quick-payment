<?php

namespace App\Jobs;

use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Services\Shared\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPaymentNotificationToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $paymentId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($paymentId)
    {
        $this->paymentId = $paymentId;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NotificationService $notificationService, PaymentRepository $paymentRepository, UserRepository $userRepository)
    {
//        $payment=$paymentRepository->findById($this->paymentId);
//        $customerPhone= $payment->customer->phone;
//        $merchants= $userRepository->getBy('phone','+963'. $customerPhone);
//        foreach($merchants as $merchant){
//            $notificationService->send($merchant->id,__('payment.new_payment_title',[],$merchant->language),__('payment.new_payment_body',['payment'=>$payment->amount, 'merchant' => $payment->user->full_name],$merchant->language),['payment_id' => $this->paymentId , 'image' => null]);
//        }

    }
}
