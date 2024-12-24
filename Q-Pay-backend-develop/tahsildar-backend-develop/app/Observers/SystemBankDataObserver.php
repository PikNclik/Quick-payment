<?php

namespace App\Observers;

use App\Models\SystemBankData;
use App\Repositories\Eloquent\SystemBankDataRepository;

class SystemBankDataObserver
{

    public function __construct(private SystemBankDataRepository $systemBankDataRepository)
    {
    }

    /**
     * Handle the SystemBankData "created" event.
     *
     * @param SystemBankData $systemBankData
     * @return void
     */
    public function created(SystemBankData $systemBankData)
    {
        if ($systemBankData->default_transaction)
            $this->systemBankDataRepository->updateDefaultTransaction($systemBankData);
    }

    /**
     * Handle the SystemBankData "updated" event.
     *
     * @param SystemBankData $systemBankData
     * @return void
     */
    public function updated(SystemBankData $systemBankData)
    {
        if ($systemBankData->default_transaction)
            $this->systemBankDataRepository->updateDefaultTransaction($systemBankData);
    }
}
