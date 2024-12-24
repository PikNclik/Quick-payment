<?php

namespace App\Http\Controllers\Api\User;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Definitions\PaymentStatus;
use App\Definitions\PaymentTypeEnums;
use App\Exports\PaymentExport;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\User\getPaidAmountRequest;
use App\Http\Requests\User\PaymentRequest;
use App\Imports\PaymentRequestImport;
use App\Jobs\SendPaymentNotificationToUser;
use App\Jobs\SendSmsToPhone;
use App\Models\Payment;
use App\Services\CustomerService;
use App\Services\PaymentService;
use App\Services\TerminalBankService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use League\Glide\Api\Api;


class PaymentCrudController extends BaseCrudController
{
    /** @var string */
    protected string $request = PaymentRequest::class;

    protected array $with = ['user.city', 'customer'];

    protected bool $searchInRelation = true;
    protected array $searchableFields = [
        'Payment' => ['amount', 'details'],
        'Customer' => ['name' => 'customer', 'attributes' => ['name', 'phone']],
    ];
    /**
     * PaymentCrudController constructor.
     * @param PaymentService $service
     * @param TerminalBankService $terminalBankService
     * @param CustomerService $customerService
     */
    public function __construct(
        PaymentService              $service,
        private TerminalBankService $terminalBankService,
        private CustomerService     $customerService
    ) {
        parent::__construct($service);
    }

    /**
     * Display a listing of the resource
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $request = resolve($this->request);
        $filters = $request->all();
        $filters['user_id'] = Auth::id();
        $filters['hide_children'] = true;
        $isPaginate = $request->isPaginate ?: "true";

        return $this->handleSharedMessage(
            $this->service->index(
                $this->columns,
                $this->with,
                $request->per_page ?? $this->length,
                $request->sort_keys ?? ['id'],
                $request->sort_dir ?? ['desc'],
                $filters,
                $this->searchableFields,
                $request->search ?? null,
                $this->searchInRelation,
                $request->withTrash ?? 0,
                $this->joinsArray,
                $isPaginate === 'true'
            )
        );
    }

    public function store(): JsonResponse
    {
        if (!Auth::user()->active)
            return $this->handleSharedMessage(new ApiSharedMessage(__('errors.prevent'), [], false, null, 403));
        $request = resolve($this->request);
        $payload = $request->validated();

        // get customer id
        try {
            $this->customerService->extractCustomer($payload);
        } catch (\Exception $exc) {
            return $this->handleSharedMessage(new ApiSharedMessage(__('errors.not_found'), [], false, null, 404));
        }

        $payload['type'] = PaymentTypeEnums::PAYMENT;
        $payload['user_id'] = Auth::id();
        $payload['terminal_bank_id'] = $this->terminalBankService->getElementBy('active', 1)->id;
        $payload['status'] = empty($payload['scheduled_date']) ? PaymentStatus::PENDING : PaymentStatus::SCHEDULED;
        $result = $this->service->store($payload);

        if ($result->data->status == PaymentStatus::PENDING) {
            $result = $this->service->view($result->data->id, ['*'], ['user', 'customer']);
            $payment = $result->data;
            SendSmsToPhone::dispatch($payment->customer->phone, __('payment.payment_link', ['name' => $payment->user->full_name], $payment->user->language) . ' ' . config('app.url') . '/payForm/' . $payment->uuid);
            SendPaymentNotificationToUser::dispatch($payment->id);
        }
        return $this->handleSharedMessage($result);
    }

    public function show(int $id): JsonResponse
    {
        $result = $this->service->view($id, ['*'], ['user', 'customer']);
        if ($result->data->user_id != Auth::id() && "+963".$result->data->customer->phone != Auth::user()->phone) {
            return $this->handleSharedMessage(new ApiSharedMessage(__('errors.unauthorized'), null, false, null, 400));
        }
        return $this->handleSharedMessage($result);
    }

    public function getSumPaidAmount(getPaidAmountRequest $request): JsonResponse
    {
        $user_id = Auth::id();
        return $this->handleSharedMessage($this->service->getSumAmount($user_id, $request->validated()));
    }

    public function export()
    {
        $request = resolve($this->request);
        $filters = $request->all();
        $filters['user_id'] = Auth::id();
        $unwantedColumns = explode(',', $request['unwanted_columns']);
        return $this->service->export(
            PaymentExport::class,
            $unwantedColumns,
            $this->columns,
            $this->with,
            $request->per_page ?? $this->length,
            $request->sort_keys ?? ['id'],
            $request->sort_dir ?? ['desc'],
            $filters,
            $this->searchableFields,
            $request->search ?? null,
            $this->searchInRelation,
            $request->withTrash ?? 0,
            $this->joinsArray,
            false
        );
    }

    public function exportPdf(int $id)
    {
        return $this->service->exportPdf($id );
    }

    public function cancel(int $id): JsonResponse
    {
        $model = $this->service->view($id)->data;
        if ($model->user_id != Auth::id())
            return $this->handleSharedMessage(new ApiSharedMessage(__('errors.forbidden'), [], false, null, 403));


        return $this->handleSharedMessage($this->service->cancel($id));
    }

    public function update(int $id): JsonResponse
    {
        if (!Auth::user()->active)
            return $this->handleSharedMessage(new ApiSharedMessage(__('errors.prevent'), [], false, null, 403));


        $model = $this->service->view($id)->data;
        if ($model->user_id != Auth::id())
            return $this->handleSharedMessage(new ApiSharedMessage(__('errors.forbidden'), [], false, null, 403));

        if ($model->status != PaymentStatus::SCHEDULED)
            return $this->handleSharedMessage(new ApiSharedMessage(__('errors.forbidden'), [], false, null, 400));

        $request = resolve($this->request);
        $payload = $request->validated();
        try {
            $this->customerService->extractCustomer($payload);
        } catch (\Exception $exc) {
            return $this->handleSharedMessage(new ApiSharedMessage(__('errors.not_found'), [], false, null, 404));
        }
        $payload['type'] = PaymentTypeEnums::PAYMENT;
        $payload['status'] = empty($payload['scheduled_date']) ? PaymentStatus::PENDING : PaymentStatus::SCHEDULED;
        $result = $this->service->update($id, $payload);
        if ($result->data->status == PaymentStatus::PENDING) {
            $result = $this->service->view($result->data->id, ['*'], ['user', 'customer']);
            $payment = $result->data;
            SendSmsToPhone::dispatch($payment->customer->phone, __('payment.payment_link', ['name' => $payment->user->full_name], $payment->user->language) . ' ' . config('app.url') . '/payForm/' . $payment->uuid)->afterResponse();
            SendPaymentNotificationToUser::dispatch($payment->id);
        }
        return $this->handleSharedMessage($result);
    }

    public function import(ImportRequest $request)
    {
        return $this->handleSharedMessage($this->service->import(new PaymentRequestImport($this->service, $this->customerService, $this->terminalBankService), $request->file('file')));
    }


    public function bulkPaymentCheck(Request $request)
    {
        $data = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:payments,id',
        ]);
        $paymentList = Payment::select(
            'id',
            'uuid',
            'amount',
            'details',
            'status',
            'paid_at',
            'user_id',
            'created_at',
            'scheduled_date',
            'expiry_date'
        )->whereIn('id', $data['ids'])->get();
        foreach ($paymentList as $payment) {
            if ($payment->user_id != Auth::id()) {
                return $this->handleSharedMessage(new ApiSharedMessage(
                    __('errors.unauthorized', []),
                    [],
                    false,
                    __('errors.unauthorized'),
                    401
                ));
            }
        }
        return $this->handleSharedMessage(new ApiSharedMessage(
            __('success.all', []),
            $paymentList,
            true,
            null,
            200
        ));
    }

    public function bulkPaymentJson(Request $request)
    {
        $data = $request->validate([
            'scheduled_date' => 'nullable|date|date_format:Y/m/d|after:now',
            'expiry_date' => 'nullable|date|date_format:Y/m/d|after:scheduled_date|after:now',
            'amount' => 'required|integer',
            'payment_type' => 'nullable|in:NORMAL,PARTIAL,FOLLOW-UP',
            'min_part_limit' => 'nullable|integer',
            'details' => 'nullable',
            'payers' => 'required|array|min:1|max:1000',
            'payers.*.payer_mobile_number' => 'required|regex:/^9\d{8}$/',
            'payers.*.payer_name' => 'required|max:255',
            'payers.*.merchant_reference' => 'nullable',
        ]);


        return $this->handleSharedMessage($this->service->storeBulkJson($data));
    }

    public function getStatistics(Request $request)
    {
        $data = $request->validate([
            'from_date' => 'required|date|date_format:Y-m-d',
            'to_date' => 'required|date|date_format:Y-m-d'
        ]);
        $data['userId'] = Auth::id();
        return $this->handleSharedMessage(
            $this->service->getStatistics($data)
        );
    }


    public function resendSms(Request $request): JsonResponse
    {
        if (!Auth::user()->active)
            return $this->handleSharedMessage(new ApiSharedMessage(__('errors.prevent'), [], false, null, 403));
        $data = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:payments,id',
        ]);

        foreach ($data['ids'] as $id) {
            $payment = $this->service->view($id, ['*'], ['user', 'customer'])->data;
            if ($payment->status == PaymentStatus::PENDING) {
                SendSmsToPhone::dispatch($payment->customer->phone, __('payment.payment_link', ['name' => $payment->user->full_name], $payment->user->language) . ' ' . config('app.url') . '/payForm/' . $payment->uuid);
                SendPaymentNotificationToUser::dispatch($payment->id);
            }
        }

        return $this->handleSharedMessage(new ApiSharedMessage(
            __('success.index'),
            [],
            true,
            null,
            200
        ));
    }

    public function getMerchantPaymentsAsCustomer(Request $request)
    {
        $data = $request->validate([
            'status' => 'required|numeric',
        ]);
        $user=Auth::user();

        $data['phone'] = $user->removeCountryCode();
        return $this->handleSharedMessage(
            $this->service->getMerchantPaymentsAsCustomer($data)
        );
    }


}
