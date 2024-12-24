<?php

namespace App\Repositories\Eloquent;

use App\Models\BaseModel;
use App\Models\SystemBankData;
use App\Repositories\SystemBankDataRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SystemBankDataRepository extends BaseRepository implements SystemBankDataRepositoryInterface
{
    /**
     * BankRepository constructor.
     * @param SystemBankData $model
     */
    public function __construct(SystemBankData $model)
    {
        parent::__construct($model);
    }

    public function updateDefaultTransaction(SystemBankData $systemBankData): bool
    {
        return $this->model
            ->where('bank_id', $systemBankData->bank_id)
            ->where('id', '!=', $systemBankData->id)
            ->update(['default_transaction' => false]);
    }

    public function getDefaultTransactionAccount($bank_id): Model|BaseModel|null
    {
        return $this->model
            ->where('bank_id', $bank_id)
            ->where('default_transaction', true)
            ->first();
    }
}
