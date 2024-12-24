<?php

namespace App\Repositories\Eloquent;

use App\Models\Commission;

class CommissionRepository extends BaseRepository
{
    /**
     * CommissionRepository constructor.
     * @param Commission $model
     */
    public function __construct(Commission $model)
    {
        parent::__construct($model);
    }

    public function checkTerminalBank($terminalBankId, $id = null)
    {
        $query = Commission::where('terminal_bank_id', $terminalBankId);
        if ($id != null)
            $query->where('id', '!=', $id);


        return $query->exists();
    }
}
