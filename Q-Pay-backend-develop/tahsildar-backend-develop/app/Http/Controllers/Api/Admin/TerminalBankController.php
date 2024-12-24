<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\TerminalBankCommissionRequest;
use App\Http\Requests\Admin\TerminalBankRequest;
use App\Models\TerminalBank;
use App\Services\TerminalBankService;

class TerminalBankController extends BaseCrudController
{
    protected string $request = TerminalBankRequest::class;

    protected array $with = ['bank'];

    public function __construct(TerminalBankService $service)
    {
        parent::__construct($service);
    }


    public function getInternalCommision($terminal_bank_id)
    {
        
        return $this->handleSharedMessage($this->service->getCommission($terminal_bank_id, 'internal'));
    }

    public function getExternalCommision($terminal_bank_id)
    {
        
        return $this->handleSharedMessage($this->service->getCommission($terminal_bank_id, 'external'));
    }

    public function setInternalCommision($terminal_bank_id, TerminalBankCommissionRequest $request)
    {
        
        return $this->handleSharedMessage($this->service->setCommission($terminal_bank_id, 'internal',$request->all()));
    }

    public function setExternalCommision($terminal_bank_id, TerminalBankCommissionRequest $request)
    {
        
        return $this->handleSharedMessage($this->service->setCommission($terminal_bank_id, 'external',$request->all()));
    }
}
