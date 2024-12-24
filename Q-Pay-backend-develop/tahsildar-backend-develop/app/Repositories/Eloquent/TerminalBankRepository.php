<?php

namespace App\Repositories\Eloquent;

use App\Models\Commission;
use App\Models\TerminalBank;
use App\Repositories\TerminalBankRepositoryInterface;

class TerminalBankRepository extends BaseRepository implements TerminalBankRepositoryInterface
{
    /**
     * BankRepository constructor.
     * @param TerminalBank $model
     */
    public function __construct(TerminalBank $model)
    {
        parent::__construct($model);
    }

    public function setCommission($id, $type, $data)
    {
        $terminalBank = $this->findById($id);
        $commissionType =  $type == "internal" ? "internal_commission" : "external_commission";
        if ($terminalBank->$commissionType) {
            $terminalBank->$commissionType->commission_percentage = $data['commission_percentage'];
            $terminalBank->$commissionType->commission_fixed = $data['commission_fixed'];
            $terminalBank->$commissionType->min = $data['min'];
            $terminalBank->$commissionType->max = $data['max'];
            $terminalBank->$commissionType->bank_account_number = $data['bank_account_number'];
            $terminalBank->$commissionType->type = $data['type'];
            $terminalBank->$commissionType->save();
        } else {
            $commission = new Commission([
                'commission_percentage' => $data['commission_percentage'],
                'commission_fixed' => $data['commission_fixed'],
                'min' => $data['min'],
                'max' => $data['max'],
                'bank_account_number' => $data['bank_account_number'],
                'type' => $data['type']
            ]);
            $commission->save();

            $terminalBank->$commissionType()->associate($commission);
            $terminalBank->save();
        }

        return $terminalBank;
    }
}
