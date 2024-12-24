<?php

namespace App\Http\Controllers\Api\Admin;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\SystemBankDataRequest;
use App\Services\SystemBankDataService;
use Illuminate\Http\JsonResponse;

class SystemBankDataController extends BaseCrudController
{

    protected string $request = SystemBankDataRequest::class;

    protected array $with = ['bank'];

    protected array $columns = ['*'];

    public function __construct(SystemBankDataService $service)
    {
        parent::__construct($service);
    }

    public function show(int $id): JsonResponse
    {
        return $this->handleSharedMessage($this->service->view($id,$this->columns,$this->with));
    }

    public function store(): JsonResponse
    {
        $request = resolve($this->request)->validated();
        $bank_id = $request['bank_id'];
        if (!$this->service->getDefaultTransactionAccount($bank_id) && !$request['default_transaction'])
            return $this->handleSharedMessage(
                new ApiSharedMessage(__('errors.default_transaction_error'), null, false, null, 400)
            );
        return $this->handleSharedMessage($this->service->store($request));
    }

    public function update(int $id)
    {
        $request = resolve($this->request)->validated();
        $model = $this->service->view($id)->data;
        $default_transaction = $model->default_transaction;
        if ((!$request['default_transaction'] && $default_transaction) ||
            (!$this->service->getDefaultTransactionAccount($model->bank_id) && !$request['default_transaction']))
            return $this->handleSharedMessage(
                new ApiSharedMessage(__('errors.default_transaction_error'), null, false, null, 400)
            );
        return $this->handleSharedMessage($this->service->update($id, $request));
    }
}
