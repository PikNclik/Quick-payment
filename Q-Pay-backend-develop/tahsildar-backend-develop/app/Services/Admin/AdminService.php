<?php

namespace App\Services\Admin;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Repositories\Eloquent\AdminRepository;
use App\Services\BaseService;

class AdminService extends BaseService
{
    /**
     * AdminService constructor.
     * @param AdminRepository $repository
     */
    public function __construct(AdminRepository $repository)
    {
        parent::__construct($repository);
    }

   
}
