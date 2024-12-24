<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\User\CreatePaymentRequest;
use App\Http\Requests\User\ExecutePaymentRequest;
use App\Services\TransferService;
use Illuminate\Http\JsonResponse;

class TransferController extends BaseController
{
    public function __construct(private TransferService $service)
    {
    }

    public function createPayment(CreatePaymentRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->service->createPayment($request->validated()));
    }

    public function executePayment(ExecutePaymentRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->service->executePayment($request->validated()));
    }
}
