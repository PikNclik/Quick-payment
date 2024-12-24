<?php

namespace App\Filters\Payment;

use App\Filters\Types\ValueFilter;

class TypeFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('type');
    }
}
