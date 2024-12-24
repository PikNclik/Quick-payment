<?php

namespace App\Services;


use App\Common\SharedMessages\ApiSharedMessage;
use App\Definitions\PaymentStatus;
use App\Definitions\PaymentTypeEnums;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\PaymentRepository;
use App\Services\Admin\TransactionToDoService;
use Illuminate\Support\Facades\Auth;

class TransferService
{

    public function __construct(private CustomerRepository $customerRepository,
                                private PaymentRepository $paymentRepository,
                                private TransactionToDoService $transactionToDoService,
                                private TerminalBankService $terminalBankService)
    {
    }

    public function createPayment($payload)
    {
        $amount = $payload['amount'];
        unset($payload['amount']);
        // create or get customer
        $customer = $this->customerRepository->updateOrCreate($payload, $payload);

        // get terminal bank id
        $terminal_bank_id = $this->terminalBankService->getElementBy('active',1)->id;

        // create payment request
        $payment_data = [
            'amount' => $amount,
            'details' => '',
            'terminal_bank_id' => $terminal_bank_id,
            'status' => PaymentStatus::PENDING,
            'customer_id' => $customer->id,
            'type' => PaymentTypeEnums::TRANSFER,
            'user_id' => Auth::id()
        ];

        $result = $this->paymentRepository->create($payment_data);
        return new ApiSharedMessage(__('success.store_payment'),$result->id,true,null,200);
    }

    public function executePayment($payload): ApiSharedMessage
    {
        $payment_id = $payload['payment_id'];
        $this->paymentRepository->update($payment_id, ['status' => PaymentStatus::PAID]);
        $this->transactionToDoService->createToDoForPayment($payment_id);
        return new ApiSharedMessage(__('success.execute')
            ,null,true, null,200);
    }

}
