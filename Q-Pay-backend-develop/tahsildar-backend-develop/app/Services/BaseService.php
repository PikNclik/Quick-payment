<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Common\SharedMessages\ApiSharedMessage;
use App\Repositories\Eloquent\BaseRepository;

class BaseService
{
    /** @var string */
    protected string $modelName = "Resource";

    /** @var BaseRepository */
    protected BaseRepository $repository;

    /**
     * BaseService constructor.
     * @param BaseRepository $repository
     */
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $columns
     * @param array $relations
     * @param int $length
     * @param array|string[] $sortKeys
     * @param array|string[] $sortDir
     * @param array $filters
     * @param array $searchableFields
     * @param string|null $search
     * @param bool $searchInRelation
     * @param int $withTrash
     * @param array $joinsArray
     * @return ApiSharedMessage
     */
    public function index(
        array  $columns = [],
        array  $relations = [],
        int    $length = 10,
        array  $sortKeys = ['id'],
        array  $sortDir = ['asc'],
        array  $filters = [],
        array  $searchableFields = [],
        string $search = null,
        bool   $searchInRelation = false,
        int    $withTrash = 0,
        array  $joinsArray = [],
        bool   $isPaginate = true
    ): ApiSharedMessage
    {
        return new ApiSharedMessage(__('success.all', ['model' => $this->modelName]),
            $this->repository->all($columns, $relations, $length, $sortKeys, $sortDir, $filters, $searchableFields, $search, $searchInRelation, $withTrash, $joinsArray,$isPaginate),
            true,
            null,
            200
        );
    }

    /**
     * Get custom resource by id
     *
     * @param int $id
     * @param array|string[] $columns
     * @param array $relations
     * @param array $appends
     * @return ApiSharedMessage
     */
    public function view(int $id, array $columns = ['*'], array $relations = [], array $appends = []): ApiSharedMessage
    {
        return new ApiSharedMessage(__('success.get', ['model' => $this->modelName]),
            $this->repository->findById($id, $columns, $relations, $appends),
            true,
            null,
            200
        );
    }

    /**
     * @param $payload
     * @return ApiSharedMessage
     */
    public function store($payload): ApiSharedMessage
    {
        return new ApiSharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->create($payload),
            true,
            null,
            200
        );
    }

    /**
     * Update By Id
     *
     * @param int $id
     * @param array $payload
     * @param array $options
     * @return ApiSharedMessage
     */
    public function update(int $id, array $payload, array $options = []): ApiSharedMessage
    {
        return new ApiSharedMessage(__('success.update', ['model' => $this->modelName]),
            $this->repository->update($id, $payload, $options),
            true,
            null,
            200
        );
    }

    /**
     * Delete by id (soft delete or force delete).
     *
     * @param int $id
     * @param bool|false $wantSoftDelete
     * @return ApiSharedMessage
     */
    public function delete(int $id, bool $wantSoftDelete = false): ApiSharedMessage
    {
        // Check Has defined soft delete or force delete.
        $hasSoftDelete = $this->repository->checkModelHasSoftDelete();

        $result = ($hasSoftDelete && $wantSoftDelete) ?
            $this->repository->applySoftDelete($id) :
            $this->repository->deleteById($id);

        return new ApiSharedMessage(__('success.delete', ['model' => $this->modelName]),
            $result,
            true,
            null,
            200
        );
    }

    /**
     * Update number of rows in the DB by specified field name.
     *
     * @param $column
     * @param $columnValue
     * @param $payload
     * @return ApiSharedMessage
     */
    public function updateBy($column, $columnValue, $payload): ApiSharedMessage
    {
        return new ApiSharedMessage(__('success.update', ['model' => $this->modelName]),
            $this->repository->updateBy($column, $columnValue, $payload),
            true,
            null,
            200
        );
    }
}
