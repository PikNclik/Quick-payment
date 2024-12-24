<?php

namespace App\Filters\Role;

use App\Filters\Types\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Interfaces\Filter;

class HideSuperAdminFilter extends BaseFilter implements Filter
{
    public function __construct()
    {
        parent::__construct('hide_superadmin', '!=');
    }

    public function apply(Builder &$builder, array $filters)
    {
        $value = $this->checkColumnExisting($filters);
        
        if ($value != null) {
            $builder = $builder->where('id', $this->operator, 3);
        }
    }

}
