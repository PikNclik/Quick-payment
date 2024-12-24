<?php

namespace App\Filters\TransactionToDo;

use App\Filters\Types\ValueFilter;

class ToBankFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('to_bank_id', '=');
    }
}
