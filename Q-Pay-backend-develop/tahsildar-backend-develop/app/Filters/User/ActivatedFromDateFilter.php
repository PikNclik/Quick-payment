<?php

namespace App\Filters\User;

use Carbon\Carbon;
use App\Filters\Types\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;

class ActivatedFromDateFilter extends BaseFilter implements Filter
{
    public function __construct()
    {
        parent::__construct('activated_at_from', '>=');
    }

    public function apply(Builder &$builder, array $filters)
    {
        $value = $this->checkColumnExisting($filters);
        
        if ($value != null) {
            $value = Carbon::createFromFormat('Y-m-d', $value)->startOfDay()->format('Y-m-d H:i:s');
            $builder = $builder->whereDate('activated_at', $this->operator, $value);
        }
    }

}
