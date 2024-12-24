<?php

namespace App\Repositories\Eloquent;

use App\Models\BusinessType;


class BusinessTypeRepository extends BaseRepository
{
    /**
     * BusinessTypeRepository constructor.
     * @param BusinessType $model
     */
    public function __construct(BusinessType $model)
    {
        parent::__construct($model);
    }
}
