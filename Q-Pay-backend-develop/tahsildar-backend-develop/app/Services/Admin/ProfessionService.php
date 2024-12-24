<?php

namespace App\Services\Admin;

use App\Repositories\Eloquent\ProfessionRepository;
use App\Services\BaseService;

class ProfessionService extends BaseService
{
  /**
     * ProfessionService constructor.
     * @param ProfessionRepository $repository
     */
    public function __construct(ProfessionRepository $repository)
    {
        parent::__construct($repository);
    }
}
