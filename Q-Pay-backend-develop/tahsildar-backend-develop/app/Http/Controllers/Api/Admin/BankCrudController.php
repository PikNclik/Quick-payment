<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\BankRequest;
use App\Services\BankService;

class BankCrudController extends BaseCrudController
{
    /** @var string */
    protected string $request = BankRequest::class;

    protected array $searchableFields = ['Bank' => ['name'] ];

    /**
     * BankCrudController constructor.
     * @param BankService $service
     */
    public function __construct(BankService $service)
    {
        parent::__construct($service);
    }
}
