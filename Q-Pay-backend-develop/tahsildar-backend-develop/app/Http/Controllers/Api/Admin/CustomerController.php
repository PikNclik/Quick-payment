<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\CustomerExport;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\CustomerRequest;
use App\Services\CustomerService;

class CustomerController extends BaseCrudController
{
    protected string $request = CustomerRequest::class;

    protected array $with = ['bank'];

    public function __construct(CustomerService $service)
    {
        parent::__construct($service);
    }

    public function export()
    {
        $request = resolve($this->request);
        $filters = $request->all();
        return $this->service->export(
            CustomerExport::class,
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
}
