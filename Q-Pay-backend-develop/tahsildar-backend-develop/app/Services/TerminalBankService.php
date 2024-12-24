<?php

namespace App\Services;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Repositories\Eloquent\TerminalBankRepository;

class TerminalBankService extends BaseService
{
    /**
     * BankService constructor.
     * @param TerminalBankRepository $repository
     */
    public function __construct(TerminalBankRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getElementBy($column, $value)
    {
        return $this->repository->getElementBy($column, $value);
    }

    public function getCommission($id, $type)
    {
        $terminalBank = $this->repository->findById($id);
        $result = $type == "internal" ? $terminalBank->internal_commission :  $terminalBank->external_commission;
        return new ApiSharedMessage(
            __('success.update', ['model' => $this->modelName]),
            $result,
            true,
            null,
            200
        );
    }

    public function setCommission($id, $type,$data)
    {
        return new ApiSharedMessage(
            __('success.update', ['model' => $this->modelName]),
            $this->repository->setCommission($id, $type,$data),
            true,
            null,
            200
        );
    }
}
