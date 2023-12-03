<?php

namespace App\Filters\Payment;

use App\Filters\Types\ValueFilter;;

class UserFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('user_id', '=');
    }

}
