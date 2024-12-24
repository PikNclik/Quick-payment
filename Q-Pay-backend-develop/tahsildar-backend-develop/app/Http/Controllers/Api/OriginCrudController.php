<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\OriginRequest;
use App\Services\OriginService;

class OriginCrudController extends BaseCrudController
{
     /** @var string */
     protected string $request = OriginRequest::class;

    protected array $searchableFields = ['Origin' => ['name']];

    /**
     * OriginCrudController constructor.
     * @param OriginService $service
     */
    public function __construct(OriginService $service)
    {
        parent::__construct($service);
    }
}
