<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;

class PermissionRepository extends BaseRepository
{
    /**
     * PermissionRepository constructor.
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
}
