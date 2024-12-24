<?php

namespace App\Repositories\Eloquent;

use App\Models\PermissionCategory;

class PermissionCategoryRepository extends BaseRepository
{
    /**
     * PermissionCategoryRepository constructor.
     * @param PermissionCategory $model
     */
    public function __construct(PermissionCategory $model)
    {
        parent::__construct($model);
    }
}
