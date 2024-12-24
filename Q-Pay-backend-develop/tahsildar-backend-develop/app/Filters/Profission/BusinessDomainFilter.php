<?php

namespace App\Filters\Profission;

use App\Filters\Types\ValueFilter;

class BusinessDomainFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('business_domain_id', '=');
    }
}
