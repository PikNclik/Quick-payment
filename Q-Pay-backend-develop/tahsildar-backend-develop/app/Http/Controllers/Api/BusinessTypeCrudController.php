<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\BusinessTypeRequest;
use App\Services\BusinessTypeService;

class BusinessTypeCrudController  extends BaseCrudController
{
     /** @var string */
     protected string $request = BusinessTypeRequest::class;

    protected array $searchableFields = ['BusinessType' => ['name']];

    /**
     * BusinessTypeCrudController constructor.
     * @param BusinessTypeService $service
     */
    public function __construct(BusinessTypeService $service)
    {
        parent::__construct($service);
    }
}
