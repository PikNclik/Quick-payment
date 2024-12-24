<?php

namespace App\Services;

use App\Repositories\Eloquent\BusinessDomainRepository;

class BusinessDomainService extends BaseService
{
    /**
     * BusinessDomainService constructor.
     * @param BusinessDomainRepository $repository
     */
    public function __construct(BusinessDomainRepository $repository)
    {
        parent::__construct($repository);
    }
}