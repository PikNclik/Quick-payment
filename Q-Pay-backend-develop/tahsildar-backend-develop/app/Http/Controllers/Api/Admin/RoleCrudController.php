<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\RoleRequest;
use App\Services\Admin\RoleService;
use Illuminate\Http\Request;

class RoleCrudController  extends BaseCrudController
{
     /** @var string */
     protected string $request = RoleRequest::class;

     /**
     * RoleCrudController constructor.
     * @param RoleService $service
     */
    public function __construct(RoleService $service)
    {
        parent::__construct($service);
    }

    public function index()
    {
        $request = resolve($this->request);
        $filters = $request->all();
        $filters['hide_superadmin'] = true;
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

    public function show(int $id)
    {
        return $this->handleSharedMessage($this->service->view($id,['*'],['permissions']));
    }

    public function setPermissions(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:roles,id',
            'permissions' => 'sometimes|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        return $this->handleSharedMessage($this->service->setPermissions($validatedData['id'],$validatedData['permissions']));
    }
}
