<?php

namespace App\Filters\TerminalBank;

use App\Filters\Types\ValueFilter;

class BankFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('bank_id', '=');
    }
}
