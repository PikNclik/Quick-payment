<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    /**
     * RoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function setPermissions($roleId, $permissions){

        $role=$this->findById($roleId);
        $role->permissions()->sync($permissions);
        return true;
        
    }
}
