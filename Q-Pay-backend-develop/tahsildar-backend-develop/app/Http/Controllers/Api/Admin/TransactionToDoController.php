<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\TransactionToDoALBarakaInternalExport;
use App\Exports\TransactionToDoExport;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\TransactionToDoRequest;
use App\Http\Requests\ImportRequest;
use App\Imports\TransactionToDoImport;
use App\Models\TransactionToDo;
use App\Services\Admin\TransactionToDoService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Monolog\Logger;

class TransactionToDoController extends BaseCrudController
{
    protected string $request = TransactionToDoRequest::class;

    protected array $with = ['to_bank', 'from_bank'];

    public function __construct(TransactionToDoService $service)
    {
        parent::__construct($service);
    }

    public function index()
    {
        $request = resolve($this->request);
        $filters = $request->all();
        $isPaginate = $request->isPaginate ?: "true";
        return $this->handleSharedMessage(
            $this->service->getTransactionToDoList($request->per_page ?? $this->length, $filters, $this->with, $request->sort_keys ?? ['id'], $request->sort_dir ?? ['desc'])
        );
    }

    public function show(int $id)
    {
        return $this->handleSharedMessage($this->service->view($id,['*'],$this->with));
    }


    public function export()
    {
        $request = resolve($this->request);
        $filters = $request->all();
        return $this->service->export(
            TransactionToDoExport::class,
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
        return $this->handleSharedMessage($this->service->import(TransactionToDoImport::class, $request->file('file')));
    }


    public function exportAlbarakaTransactions()
    {
       return $this->service->exportAlbarakaTransactions();
    }

}
