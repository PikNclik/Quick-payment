<?php

namespace App\Services;

use App\Repositories\Eloquent\OriginRepository;

class OriginService extends BaseService
{
    /**
     * OriginService constructor.
     * @param OriginRepository $repository
     */
    public function __construct(OriginRepository $repository)
    {
        parent::__construct($repository);
    }
}