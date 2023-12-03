<?php

namespace App\Http\Controllers;

use App\Definitions\PaymentStatus;
use App\Http\Requests\PickRequest;
use App\Services\PaymentService;
use App\Services\Shared\PickService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    private PickService $pickService;
    public function __construct(PaymentService $paymentService,PickService $pickService)
    {
        $this->paymentService = $paymentService;
        $this->pickService = $pickService;
    }

    public function formPay(string $id): Factory|View|Application
    {
      $payment =  $this->paymentService->getByUuid($id);
        if ($payment) {
            if ($payment->status == PaymentStatus::EXPIRED) {
                return \view('payment.error', ['message' => 'Payment has been expired !']);
            }
            if ($payment->status == PaymentStatus::PAID) {
                return \view('payment.response', ['message' => 'Payment is done !']);
            }
            else if(!in_array($payment->status, PaymentStatus::APPROVED_PAID_STATUSES)){
                return \view('payment.error', ['message' => 'Cannot reach this payment !']);
            }
            else{
                App::setLocale($payment->user->language);
                return \view('payment.pay', compact('payment'));
            }
        }
        return \view('payment.error', ['message' => 'Page not found 404 !']);
    }

    /**
     * @param string $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function pay(string $id): Application|Factory|View|RedirectResponse
    {
        $payment = $this->paymentService->getByUuid($id);
        if ($payment)
        {
            if ($payment->status == PaymentStatus::EXPIRED)
            {
                return \view('payment.error', ['message' => 'Payment has been expired !']);
            }
            if ($payment->status == PaymentStatus::PAID)
            {
                return \view('payment.response', ['message' => 'Payment is done !']);
            }
            else if(!in_array($payment->status,PaymentStatus::APPROVED_PAID_STATUSES )){
                return \view('payment.error', ['message' => 'Cannot reach this payment !']);
            }

            $token = $this->pickService->getToken($payment);

            if ($token > 0){
                $this->paymentService->update($payment->id,['token' => $token]);
                return redirect()->to(env('PICKURL').'/IPG/Payment?Token='.$token);
            }

            return \view('payment.error', ['message' => 'Page not found 404 !']);
        }
        return \view('payment.error', ['message' => 'Page not found 404 !']);
    }

    public function callBack(PickRequest $request): View|Factory|Application
    {
        $result = $this->pickService->callBack($request->validated());
        if ($result)
            return \view('payment.confirm', ['payment' => $result]);

        return \view('payment.error', ['message' => 'Payment is Failed Please try again later']);
    }

    public function confirmPayment($uuid): View|Factory|Application
    {
        $payment = $this->paymentService->getByUuid($uuid);
        if ($payment) {
            $result = $this->pickService->confirmPayment($payment);
            if ($result)
                return \view('payment.response', ['message' => 'Payment is done !']);

            return \view('payment.error', ['message' => 'Payment is Failed Please try again later']);

        }
        return \view('payment.error', ['message' => 'Payment is Failed Please try again later']);
    }

    public function reversePayment($uuid): View|Factory|Application
    {
        $payment = $this->paymentService->getByUuid($uuid);
        if ($payment) {
            $result = $this->pickService->reversePayment($payment);
            if ($result)
                return \view('payment.error', ['message' => 'Payment is Reversed done !']);

            return \view('payment.error', ['message' => 'Payment is Failed Please try again later']);

        }
        return \view('payment.error', ['message' => 'Payment is Failed Please try again later']);
    }
}
