<?php

namespace App\Services;

use App\Repositories\Eloquent\BankRepository;

class BankService extends BaseService
{
    /**
     * BankService constructor.
     * @param BankRepository $repository
     */
    public function __construct(BankRepository $repository)
    {
        parent::__construct($repository);
    }
}