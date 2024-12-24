<?php

namespace App\Repositories\Eloquent;

use App\Models\Origin;

class OriginRepository extends BaseRepository
{
    /**
     * CityRepository constructor.
     * @param Origin $model
     */
    public function __construct(Origin $model)
    {
        parent::__construct($model);
    }
}
