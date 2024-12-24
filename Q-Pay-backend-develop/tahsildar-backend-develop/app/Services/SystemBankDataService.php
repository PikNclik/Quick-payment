<?php

namespace App\Services;

use App\Repositories\Eloquent\SystemBankDataRepository;

class SystemBankDataService extends BaseService
{
    /**
     * BankService constructor.
     * @param SystemBankDataRepository $repository
     */
    public function __construct(SystemBankDataRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getDefaultTransactionAccount($bank_id)
    {
        return $this->repository->getDefaultTransactionAccount($bank_id);
    }
}
