<?php

namespace App\Filters\Payment;

use App\Filters\Types\DateFilter;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CityFilter extends DateFilter
{
    public function __construct()
    {
        parent::__construct('city_id', '=');
    }

    public function apply(Builder &$builder, array $filters)
    {
        if(!empty($filters['city_id'])){
            $builder->whereHas('user', function ($query) use ($filters) {
                $query->where('city_id', $filters['city_id']);
            });
        }
    }
}
