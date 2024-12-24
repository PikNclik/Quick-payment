<?php

namespace App\Http\Controllers;

use App\Definitions\PaymentStatus;
use App\Http\Requests\PickRequest;
use App\Services\Admin\TransactionToDoService;
use App\Services\PaymentService;
use App\Services\Shared\IPGService;
use App\Services\Shared\PickService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use function PHPUnit\Framework\isNull;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    private PickService $pickService;
    private IPGService $ipgService;
    private TransactionToDoService $transactionToDoService;

    public function __construct(PaymentService         $paymentService,
                                PickService            $pickService,
                                IPGService $ipgService,
                                TransactionToDoService $transactionToDoService)
    {
        $this->paymentService = $paymentService;
        $this->pickService = $pickService;
        $this->ipgService = $ipgService;
        $this->transactionToDoService = $transactionToDoService;
    }

    public function formPay(string $id): Factory|View|Application
    {
      $payment =  $this->paymentService->getByUuid($id);
      $payment->load('customer');
        if ($payment) {
            if ($payment->status == PaymentStatus::EXPIRED) {
                return \view('payment.error', ['message' => 'Payment has been expired !']);
            }
            if ($payment->status == PaymentStatus::CANCELLED) {
                return \view('payment.error', ['message' => 'Payment has been cancelled !']);
            }
            if ($payment->status == PaymentStatus::PAID) {
                return \view('payment.response',  ['message' => 'Payment is done !','link'=>\App\Models\Setting::where("key","direct_app_link")->first()->value]);
            }
            else if(!in_array($payment->status, PaymentStatus::APPROVED_PAID_STATUSES)){
                return \view('payment.error', ['message' => 'Cannot reach this payment !']);
            }
            else{
                $language = 'ar';
                App::setLocale($language);
                return \view('payment.pay', compact('payment','language'));
            }
        }
        return \view('payment.error', ['message' => 'Page not found 404 !']);
    }

    /**
     * @param string $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function pay(Request $request, string $id): Application|Factory|View|RedirectResponse
    {
        $validatedData = $request->validate([
            'part' => 'nullable|numeric',
        ]);
        $part = $validatedData['part']??null;
        $payment = $this->paymentService->getByUuid($id);
        if ($payment)
        {
            if ($payment->status == PaymentStatus::EXPIRED)
            {
                return \view('payment.error', ['message' => 'Payment has been expired !']);
            }
            if ($payment->status == PaymentStatus::CANCELLED) {
                return \view('payment.error', ['message' => 'Payment has been cancelled !']);
            }
            if ($payment->status == PaymentStatus::PAID)
            {
                return \view('payment.response', ['message' => 'Payment is done !','link'=>\App\Models\Setting::where("key","direct_app_link")->first()->value]);
            }
            else if(!in_array($payment->status,PaymentStatus::APPROVED_PAID_STATUSES )){
                return \view('payment.error', ['message' => 'Cannot reach this payment !']);
            }
            if (!isNull($part) && $payment->payment_type == 'NORMAL')
            {
                return \view('payment.error', ['message' => 'this payment does not support part payment']);
            }
            if (!isNull($part) && $part > $payment->amount)
            {
                return \view('payment.error', ['message' => 'part can not be more than the actual amount']);
            }
            $actualPayment = $part ?? $payment->amount;
            $actualFee = $actualPayment *  $payment->fees_percentage / 100;
            $this->paymentService->update($payment->id,['actual_payment' => $actualPayment,
                "actual_fee"=>$actualFee]);
            $payment = $this->paymentService->getByUuid($id);
            $token = $this->ipgService->getToken($payment);
            if ($token){
                $this->paymentService->update($payment->id,['token' => $token]);
                return redirect()->to("https://ipg.piknclk.com/pay/".$token);
            }

            return \view('payment.error', ['message' => 'Page not found 404 !']);
        }
        return \view('payment.error', ['message' => 'Page not found 404 !']);
    }

    public function callBack(PickRequest $request): View|Factory|Application
    {
        $result = $this->ipgService->callBack($request->validated());
        if ($result)
            return \view('payment.response', ['message' => 'Payment is done !','link'=>\App\Models\Setting::where("key","direct_app_link")->first()->value]);

        return \view('payment.error', ['message' => 'Payment is Failed Please try again later']);
    }

    public function confirmPayment($uuid): View|Factory|Application
    {
        $payment = $this->paymentService->getByUuid($uuid);
        if ($payment) {
            $result = $this->pickService->confirmPayment($payment);
            if ($result) {
                $this->transactionToDoService->createToDoForPayment($payment->id);
                return \view('payment.response', ['message' => 'Payment is done !','link'=>\App\Models\Setting::where("key","direct_app_link")->first()->value]);
            }

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
