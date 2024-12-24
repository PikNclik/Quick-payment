<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\CustomerRepositoryInterface;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    /**
     * BankRepository constructor.
     * @param Customer $model
     */
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }
}
