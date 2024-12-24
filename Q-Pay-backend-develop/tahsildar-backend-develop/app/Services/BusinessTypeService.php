<?php

namespace App\Services;

use App\Repositories\Eloquent\BusinessTypeRepository;

class BusinessTypeService extends BaseService
{
    /**
     * BusinessTypeService constructor.
     * @param BusinessTypeRepository $repository
     */
    public function __construct(BusinessTypeRepository $repository)
    {
        parent::__construct($repository);
    }
}