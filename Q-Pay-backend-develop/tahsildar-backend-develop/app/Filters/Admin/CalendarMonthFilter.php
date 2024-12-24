<?php

namespace App\Filters\Admin;

use App\Filters\Types\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;

class CalendarMonthFilter extends BaseFilter implements Filter
{
    public function __construct()
    {
        parent::__construct('date', '=');
    }

    public function apply(Builder &$builder, array $filters)
    {
        $builder->whereMonth('date',$filters['month']);

    }

}
