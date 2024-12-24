<?php

namespace App\Http\Controllers\Api\Admin;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Exports\AdminPaymentExport;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\PaymentRequest;
use App\Http\Requests\ImportRequest;
use App\Imports\PaymentImport;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PaymentCrudController extends BaseCrudController
{

    protected string $request = PaymentRequest::class;

     /** @var bool */
     protected bool $searchInRelation = true;

     /** @var array|array[] */
     protected array $searchableFields = [
         'Payment' => ['id','amount', 'details'],
         'User' => ['name' => 'user' , 'attributes' => ['bank_account_number','phone']],
         'Customer' => ['name' => 'customer' , 'attributes' => ['name','phone']],
         ];

    protected array $with = ['user.city','customer','transactionToDo'];
    /**
     * PaymentCrudController constructor.
     * @param PaymentService $service
     */
    public function __construct(PaymentService $service)
    {
        parent::__construct($service);
    }

    public function index(): JsonResponse
    {
        $request = resolve($this->request);
        $filters = $request->all();
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


    public function cancel(int $id): JsonResponse
    {
        return $this->handleSharedMessage($this->service->cancel($id));
    }

    public function export()
    {
        $request = resolve($this->request);
        $filters = $request->all();
        return $this->service->export(
            AdminPaymentExport::class,
            [],
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

    /**
     * Write code on Method
     * @param ImportRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function import(ImportRequest $request): JsonResponse|RedirectResponse
    {
        return $this->handleSharedMessage($this->service->import(PaymentImport::class,$request->file('file')));
    }
}
