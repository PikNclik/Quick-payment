<?php

namespace App\Filters\Payment;

use App\Filters\Types\DateFilter;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class BankFilter extends DateFilter
{
    public function __construct()
    {
        parent::__construct('bank_id', '=');
    }

    public function apply(Builder &$builder, array $filters)
    {
        if(!empty($filters['bank_id'])){
            $builder->whereHas('user', function ($query) use ($filters) {
                $query->where('bank_id', $filters['bank_id']);
            });
        }
    }
}
