<?php

namespace App\Filters\Payment;

use App\Filters\Types\DateFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class FromDateFilter extends DateFilter
{
    public function __construct()
    {
        parent::__construct('from_date', '>=');
    }

    public function apply(Builder &$builder, array $filters)
    {
        $value = $this->checkColumnExisting($filters);
        
        if ($value != null) {
            $value = Carbon::createFromFormat('Y-m-d', $value)->startOfDay()->format('Y-m-d H:i:s');
            $builder = $builder->whereDate('created_at', $this->operator, $value);
        }
    }

}
