<?php

namespace App\Filters\User;

use Carbon\Carbon;
use App\Filters\Types\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;

class CreatedFromDateFilter extends BaseFilter implements Filter
{
    public function __construct()
    {
        parent::__construct('created_at_from', '>=');
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
