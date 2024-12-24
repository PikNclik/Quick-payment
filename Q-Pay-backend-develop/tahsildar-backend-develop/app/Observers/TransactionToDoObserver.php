<?php

namespace App\Observers;

use App\Definitions\PaymentStatus;
use App\Models\TransactionToDo;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Eloquent\TransactionToDoRepository;

class TransactionToDoObserver
{
    public function __construct(
        private TransactionToDoRepository $transactionToDoRepository,
        private PaymentRepository         $paymentRepository)
    {
    }

    /**
     * Handle the TransactionToDo "updating" event.
     *
     * @param TransactionToDo $transactionToDo
     * @return void
     */
    public function updating(TransactionToDo $transactionToDo): void
    {
        if ($transactionToDo->isDirty('executed')) {
            // executed has changed
            $new_status = $transactionToDo->executed;
            $old_status = $transactionToDo->getOriginal('executed');

            if ($new_status && !$old_status) {
                $payment_id = $transactionToDo->payment_id;
                    $this->paymentRepository->update($payment_id, ['status' => PaymentStatus::SETTLED]);
            }
        }
    }
}
