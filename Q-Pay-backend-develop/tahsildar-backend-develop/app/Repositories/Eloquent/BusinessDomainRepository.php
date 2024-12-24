<?php

namespace App\Repositories\Eloquent;

use App\Models\BusinessDomain;


class BusinessDomainRepository extends BaseRepository
{
    /**
     * BusinessDomainRepository constructor.
     * @param BusinessDomain $model
     */
    public function __construct(BusinessDomain $model)
    {
        parent::__construct($model);
    }
}
