<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\MenuResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserCrudController extends BaseCrudController
{
    /** @var string */
    protected string $request = UserRequest::class;

    protected array $with = ['bank','city'];
    /**
     * UserCrudController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }

    public function index(): JsonResponse
    {
        $request = resolve($this->request);
        $filters = $request->all();
        $isPaginate = $request->isPaginate ?: "true";
        $result = $this->service->index(
            $this->columns,
            ['bank', 'payments','city'],
            $request->per_page ?? $this->length,
            $request->sort_keys ?? ['id'],
            $request->sort_dir ?? ['desc'],
            $filters,
            $this->searchableFields,
            $request->search ?? null,
            $this->searchInRelation,
            $request->withTrash ?? 0,
            $this->joinsArray,
            $isPaginate === 'true',
        );
        $result->data = new MenuResource($result->data, UserResource::class);

        return $this->handleSharedMessage($result);
    }

    public function show(int $id)
    {
        return $this->handleSharedMessage($this->service->view($id,['*'],$this->with));
    }

    public function block(int $id): JsonResponse
    {
        return $this->handleSharedMessage($this->service->block($id));
    }
}
