<?php

namespace App\Filters\User;

use App\Filters\Types\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;

class CompletedFilter extends BaseFilter implements Filter
{
    public function __construct()
    {
        parent::__construct('completed');
    }

    public function apply(Builder &$builder, array $filters)
    {
        $value = $this->checkColumnExisting($filters);

        if ($value != null) {
            if ($value == 0)
                $builder = $builder->whereNull('activated_at');
            else
                $builder = $builder->whereNotNull('activated_at');
        }
    }
}
