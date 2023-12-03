<?php

namespace App\Services;

use App\Repositories\Eloquent\CityRepository;

class CityService extends BaseService
{
    /**
     * CityService constructor.
     * @param CityRepository $repository
     */
    public function __construct(CityRepository $repository)
    {
        parent::__construct($repository);
    }
}