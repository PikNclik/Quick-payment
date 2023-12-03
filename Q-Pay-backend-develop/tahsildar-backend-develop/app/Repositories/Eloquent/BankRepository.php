<?php

namespace App\Repositories\Eloquent;

use App\Repositories\BankRepositoryInterface;
use App\Models\Bank;

class BankRepository extends BaseRepository implements BankRepositoryInterface
{
    /**
     * BankRepository constructor.
     * @param Bank $model
     */
    public function __construct(Bank $model)
    {
        parent::__construct($model);
    }
}
