<?php

namespace App\Http\Controllers\Api\User;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Definitions\PaymentStatus;
use App\Exports\PaymentExport;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\User\getPaidAmountRequest;
use App\Http\Requests\User\PaymentRequest;
use App\Jobs\SendSmsToPhone;
use App\Mail\PaymentMail;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use League\Glide\Api\Api;


class PaymentCrudController extends BaseCrudController
{
    /** @var string */
    protected string $request = PaymentRequest::class;

    /**
     * PaymentCrudController constructor.
     * @param PaymentService $service
     */
    public function __construct(PaymentService $service)
    {
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
        if(!Auth::user()->active)
        return $this->handleSharedMessage(new ApiSharedMessage(__('errors.prevent'), [], false, null, 403));
        $request = resolve($this->request);
        $payload = $request->validated();
        $payload['user_id'] = Auth::id();
        $payload['status'] = empty($payload['scheduled_date'])?PaymentStatus::PENDING: PaymentStatus::SCHEDULED;
        $result = $this->service->store($payload);

        if($result->data->status == PaymentStatus::PENDING)
        {
            $result = $this->service->view($result->data->id,['*'],['user']);
            $payment = $result->data;
            SendSmsToPhone::dispatch($payment->payer_mobile_number,__('payment.payment_link',[],$payment->user->language).' '. config('app.url').'/payForm/'.$payment->uuid);
        }
        return $this->handleSharedMessage($result);
    }

    public function show(int $id): JsonResponse
    {
        $result = $this->service->view($id,['*'],['user']);
        if ($result->data->user_id != Auth::id())
        {
            return $this->handleSharedMessage(new ApiSharedMessage(__('errors.unauthorized'),null,false,null,400));
        }
        return $this->handleSharedMessage($result);
    }

    public function getSumPaidAmount(getPaidAmountRequest $request): JsonResponse
    {
        $user_id = Auth::id();
        return $this->handleSharedMessage($this->service->getSumAmount($user_id,$request->validated()));
    }

    public function export()
    {
        $request = resolve($this->request);
        $filters = $request->all();
        $filters['user_id'] = Auth::id();
        return $this->service->export(
            PaymentExport::class,
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

    public function cancel(int $id): JsonResponse
    {
        return $this->handleSharedMessage($this->service->cancel($id));
    }

}
