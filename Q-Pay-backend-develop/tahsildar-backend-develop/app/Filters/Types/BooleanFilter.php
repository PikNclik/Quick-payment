<?php

namespace App\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;

class BooleanFilter extends BaseFilter implements Filter
{
    /**
     * @param Builder $builder
     * @param array $filters
     */
    public function apply(Builder &$builder, array $filters)
    {
        $value = $this->checkColumnExisting($filters);

        if ($value != null) {

            if ($value) {
                $builder = $builder->where($this->columnName, true);
            } else {
                $builder = $builder->where($this->columnName, false);
            }
        }
    }
}
