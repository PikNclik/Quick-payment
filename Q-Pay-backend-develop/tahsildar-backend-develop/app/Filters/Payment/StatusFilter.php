<?php

namespace App\Filters\Payment;

use App\Filters\Types\ValueFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;
class StatusFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('status');
    }
    /**
     * @param Builder $builder
     * @param array $filters
     */
    public function apply(Builder &$builder, array $filters)
    {
        if (isset($filters['status']) ) {
            $builder = $builder->whereIn($this->columnName,explode(',', $filters['status']));
        }
    }
}
