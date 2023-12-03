<?php

namespace App\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;

class ValueFilter extends BaseFilter implements Filter
{
    /**
     * @param Builder $builder
     * @param array $filters
     */
    public function apply(Builder &$builder, array $filters)
    {
        $value = $this->checkColumnExisting($filters);

        if ($value != null) {
            $builder = $builder->where($this->columnName, $this->operator, $value);
        }
    }
}
