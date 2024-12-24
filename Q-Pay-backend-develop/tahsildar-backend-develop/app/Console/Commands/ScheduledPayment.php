<?php

namespace App\Console\Commands;

use App\Definitions\PaymentStatus;
use App\Jobs\SendPaymentNotificationToUser;
use App\Jobs\SendSmsToPhone;
use App\Mail\PaymentMail;
use App\Models\User;
use App\Repositories\Eloquent\PaymentRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ScheduledPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command is change status for all payment who has scheduled date is gone';

    private PaymentRepository $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        parent::__construct();
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $payments = $this->paymentRepository->getScheduled();

        foreach ($payments as $payment)
        {
            $this->paymentRepository->update($payment->id,['status' => PaymentStatus::PENDING]);
            SendSmsToPhone::dispatch($payment->customer->phone,__('payment.payment_link',['name'=>$payment->user->full_name],$payment->user->language).' '. config('app.url').'/payForm/'.$payment->uuid);
            SendPaymentNotificationToUser::dispatch($payment->id);
        }
        return CommandAlias::SUCCESS;
    }
}
