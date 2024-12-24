<?php

namespace App\Filters\SystemBank;

use App\Filters\Types\ValueFilter;
use Illuminate\Database\Eloquent\Builder;

;

class BankNumberNotNullFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('bank_account_number');
    }

    public function apply(Builder &$builder, array $filters)
    {
        $value = $this->checkColumnExisting($filters);

        if ($value) {
            $builder = $builder->whereNotNull('bank_account_number');
        }
    }
}
