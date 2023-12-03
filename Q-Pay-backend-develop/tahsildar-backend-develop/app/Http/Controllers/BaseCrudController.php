<?php

namespace App\Http\Controllers;

use App\Services\BaseService;
use Illuminate\Http\JsonResponse;

/**
 * Class BaseCrudController
 * @package App\Http\Controllers
 */
class BaseCrudController extends BaseController
{
    /** @var bool */
    protected bool $searchInRelation = false;

    /** @var array|array[] */
    protected array $searchableFields = [];

    /** @var bool */
    protected bool $wantSoftDelete = false;

    /** @var string[] */
    protected array $joinsArray = [];

    /** @var BaseService */
    protected BaseService $service;

    /** @var array|string[] */
    protected array $columns = [];

    /** @var int */
    protected int $length = 10;

    /** @var string[] */
    protected array $with = [];

    /** @var string */
    protected string $request;

    /**
     * BaseController constructor
     * @param $service
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource
     *
     * @return JsonResponse
     */
    public function index()
    {
        $request = resolve($this->request);
        $filters = $request->all();
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

    /**
     * Store a newly created resource in storage
     *
     * @return JsonResponse
     */
    public function store()
    {
        $request = resolve($this->request);
        return $this->handleSharedMessage($this->service->store($request->validated()));
    }

    /**
     * Display the specified resource
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return $this->handleSharedMessage($this->service->view($id));
    }

    /**
     * Update the specified resource in storage
     *
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id)
    {
        $request = resolve($this->request);
        return $this->handleSharedMessage($this->service->update($id, $request->validated()));
    }

    /**
     * Remove the specified resource from storage
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        return $this->handleSharedMessage($this->service->delete($id, $this->wantSoftDelete));
    }
}
