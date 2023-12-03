<?php

namespace App\Console\Commands;

use App\Definitions\PaymentStatus;
use App\Repositories\Eloquent\PaymentRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ExpiredPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiry:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command is change status for all payment who has expired date';

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
        $payments = $this->paymentRepository->getExpired();

        foreach ($payments as $payment)
        {
            $this->paymentRepository->update($payment->id,['status' => PaymentStatus::EXPIRED]);
        }
        return CommandAlias::SUCCESS;
    }
}
