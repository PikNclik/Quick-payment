<?php

namespace App\Repositories\Eloquent;

use App\Models\WorkingDayHoliday;
use App\Repositories\BankRepositoryInterface;
use App\Models\Bank;

class WorkingDayHolidayRepository extends BaseRepository implements BankRepositoryInterface
{
    /**
     * BankRepository constructor.
     * @param WorkingDayHoliday $model
     */
    public function __construct(WorkingDayHoliday $model)
    {
        parent::__construct($model);
    }
}
