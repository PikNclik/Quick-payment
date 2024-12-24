<?php

namespace App\Filters\TransactionToDo;

use App\Filters\Types\ValueFilter;

class FromBankFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('from_bank_id', '=');
    }
}
