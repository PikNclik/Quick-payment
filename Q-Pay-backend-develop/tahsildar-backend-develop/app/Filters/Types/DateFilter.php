<?php

namespace App\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;

class DateFilter extends BaseFilter implements Filter
{
    /**
     * @param Builder $builder
     * @param array $filters
     */
    public function apply(Builder &$builder, array $filters)
    {
        $value = $this->checkColumnExisting($filters);

        if ($value != null) {
            $builder = $builder->whereDate($this->columnName, $this->operator, $value);
        }
    }
}
