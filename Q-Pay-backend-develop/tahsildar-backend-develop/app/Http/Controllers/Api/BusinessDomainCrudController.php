<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessDomainRequest;
use App\Services\BusinessDomainService;
use Illuminate\Http\Request;

class BusinessDomainCrudController  extends BaseCrudController
{
     /** @var string */
     protected string $request = BusinessDomainRequest::class;

    protected array $searchableFields = ['BusinessDomain' => ['name']];

    /**
     * BusinessDomainCrudController constructor.
     * @param BusinessDomainService $service
     */
    public function __construct(BusinessDomainService $service)
    {
        parent::__construct($service);
    }
}
