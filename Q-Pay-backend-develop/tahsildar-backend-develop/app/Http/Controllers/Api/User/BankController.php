<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\BankRequest;
use App\Services\BankService;

class BankController extends BaseCrudController
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

    public function index()
    {
        $request = resolve($this->request);
        $filters = $request->all();
        $filters['active'] = true;
        //$filters['system_bank_data'] = true;
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
}
