<?php

namespace App\Filters\User;

use Carbon\Carbon;
use App\Filters\Types\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;

class ActivatedToDateFilter extends BaseFilter implements Filter
{
    public function __construct()
    {
        parent::__construct('activated_at_to', '<=');
    }

    public function apply(Builder &$builder, array $filters)
    {
        $value = $this->checkColumnExisting($filters);

        if ($value != null) {
            $value = Carbon::createFromFormat('Y-m-d', $value)->endOfDay()->format('Y-m-d H:i:s');
            $builder = $builder->whereDate('activated_at', $this->operator, $value);
        }
    }

}
