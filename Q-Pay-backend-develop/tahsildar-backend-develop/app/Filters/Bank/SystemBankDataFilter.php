<?php

namespace App\Filters\Bank;

use App\Filters\Types\ValueFilter;
use Illuminate\Database\Eloquent\Builder;

class SystemBankDataFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('system_bank_data');
    }

    public function apply(Builder &$builder, array $filters)
    {
        $value = $this->checkColumnExisting($filters);

        if ($value) {
            $builder = $builder
                ->whereHas('system_bank_data', function ($query) {
                    return $query->whereNotNull('bank_account_number');
                });
        }
    }
}
