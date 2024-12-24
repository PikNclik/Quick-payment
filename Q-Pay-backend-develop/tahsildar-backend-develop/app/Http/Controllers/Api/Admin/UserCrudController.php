<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\MenuResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserCrudController extends BaseCrudController
{
    /** @var string */
    protected string $request = UserRequest::class;
    protected array $searchableFields = [
        'User' => ['full_name', 'phone']
        ];
    protected array $with = ['bank', 'city', 'profession'];
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
            ['bank', 'payments', 'city', 'profession'],
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
        return $this->handleSharedMessage($this->service->view($id, ['*'], $this->with));
    }
    public function store()
    {
        $request = resolve($this->request);
        $data=$request->validated();
        $data['qpay_id']="Q". chr(rand(97, 122)) . chr(rand(97, 122)) . rand(0,9) . rand(0,9) . rand(0,9);
        return $this->handleSharedMessage($this->service->store($data));
    }

    public function update(int $id)
    {
        $request = resolve($this->request);
        $user = Auth::user();
        if (!$user->role ) {
            abort(403, 'Access denied');
        }
        if ($request['full_name'] != null && $user->role->name != "Super Admin") {
            
            if (count($user->role->permissions) == 0) {
                abort(403, 'Access denied');
            }
            $permissions = $user->role->permissions->toArray();
            $filteredArray = array_filter($permissions, function ($per) {
                return strtolower($per['category_name']) == "merchants" && strtolower($per['name']) == "show all edit fields";
            });
            if (count($filteredArray) == 0)
                abort(403, 'Access denied');
        }



        return $this->handleSharedMessage($this->service->update($id, $request->validated()));
    }

    public function block(int $id): JsonResponse
    {
        return $this->handleSharedMessage($this->service->block($id));
    }

    public function getNewMerchantsCount(): JsonResponse
    {
        return $this->handleSharedMessage($this->service->getNewMerchantsCount());
    }
}
