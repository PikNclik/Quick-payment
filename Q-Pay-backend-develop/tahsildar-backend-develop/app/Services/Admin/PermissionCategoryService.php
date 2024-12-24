<?php

namespace App\Services\Admin;

use App\Repositories\Eloquent\PermissionCategoryRepository;
use App\Services\BaseService;

class PermissionCategoryService extends BaseService
{
    /**
     * PermissionCategoryService constructor.
     * @param PermissionCategoryRepository $repository
     */
    public function __construct(PermissionCategoryRepository $repository)
    {
        parent::__construct($repository);
    }
}