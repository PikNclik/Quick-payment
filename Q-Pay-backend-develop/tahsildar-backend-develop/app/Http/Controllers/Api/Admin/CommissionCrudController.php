<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\CommissionRequest;
use App\Services\CommissionService;

class CommissionCrudController extends BaseCrudController
{
    /** @var string */
    protected string $request = CommissionRequest::class;

    protected array $with = ["terminal_bank.bank"];
    /**
     * CommissionCrudController constructor.
     * @param CommissionService $service
     */
    public function __construct(CommissionService $service)
    {
        parent::__construct($service);
    }


    public function show(int $id)
    {
        return $this->handleSharedMessage($this->service->view($id,['*'],$this->with));
    }


}
