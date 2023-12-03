<?php

namespace App\Repositories\Eloquent;

use App\Repositories\CityRepositoryInterface;
use App\Models\City;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    /**
     * CityRepository constructor.
     * @param City $model
     */
    public function __construct(City $model)
    {
        parent::__construct($model);
    }
}
