<?php

namespace App\Filters\BusinessDomain;

use App\Filters\Types\ValueFilter;

class BusinessTypeFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('business_type_id', '=');
    }
}
