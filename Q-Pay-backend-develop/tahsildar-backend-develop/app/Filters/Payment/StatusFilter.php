<?php

namespace App\Filters\Payment;

use App\Filters\Types\ValueFilter;;

class StatusFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('status', '=');
    }

}
