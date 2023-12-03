<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\CityRequest;
use App\Services\CityService;

class CityCrudController extends BaseCrudController
{
    /** @var string */
    protected string $request = CityRequest::class;

    protected array $searchableFields = ['City' => ['name'] ];


    /**
     * CityCrudController constructor.
     * @param CityService $service
     */
    public function __construct(CityService $service)
    {
        parent::__construct($service);
    }
}
