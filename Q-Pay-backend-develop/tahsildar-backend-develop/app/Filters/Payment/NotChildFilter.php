<?php

namespace App\Filters\Payment;

use App\Filters\Types\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;

class NotChildFilter extends BaseFilter implements Filter
{
    public function __construct()
    {
        parent::__construct('parent_payment_id');
    }
    /**
     * @param Builder $builder
     * @param array $filters
     */
    public function apply(Builder &$builder, array $filters)
    {
        if (isset($filters['hide_children']) && $filters['hide_children']){
            $builder = $builder->whereNull($this->columnName);
        }
    }
}
