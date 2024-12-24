<?php

namespace App\Services\Admin;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Repositories\Eloquent\RoleRepository;
use App\Services\BaseService;

class RoleService extends BaseService
{
    /**
     * RoleService constructor.
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        parent::__construct($repository);
    }


    public function setPermissions($roleId, $permissions){
        return new ApiSharedMessage(__('success.update', ['model' => $this->modelName]),
            $this->repository->setPermissions($roleId, $permissions),
            true,
            null,
            200
        );
        
    }
}