<?php

namespace App\Filters\TransactionToDo;

use App\Filters\Types\ValueFilter;

class ExecutedFilter extends ValueFilter
{
    public function __construct()
    {
        dd([]);
        parent::__construct('executed', '=');
    }
}
