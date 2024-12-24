<?php

namespace App\Filters\Bank;

use App\Filters\Types\BooleanFilter;

class ActiveFilter extends BooleanFilter
{
    public function __construct()
    {
        parent::__construct('active');
    }

}
