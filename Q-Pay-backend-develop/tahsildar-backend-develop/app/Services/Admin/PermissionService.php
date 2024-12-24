<?php

namespace App\Services\Admin;

use App\Repositories\Eloquent\PermissionRepository;
use App\Services\BaseService;

class PermissionService extends BaseService
{
    /**
     * PermissionService constructor.
     * @param PermissionRepository $repository
     */
    public function __construct(PermissionRepository $repository)
    {
        parent::__construct($repository);
    }
}