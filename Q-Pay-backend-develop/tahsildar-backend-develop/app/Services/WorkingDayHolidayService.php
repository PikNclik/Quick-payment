<?php

namespace App\Services;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Models\BaseModel;
use App\Models\WorkingDayHoliday;
use App\Repositories\Eloquent\BankRepository;
use App\Repositories\Eloquent\WorkingDayHolidayRepository;

class WorkingDayHolidayService extends BaseService
{
    /**
     * BankService constructor.
     * @param WorkingDayHolidayRepository $repository
     */
    public function __construct(WorkingDayHolidayRepository $repository)
    {
        parent::__construct($repository);
    }


    public function getNextSettlementDate ()
    {

        $suggestedDate = now()->addDay();
        while ( $suggestedDate->dayOfWeek == 5 ||  $suggestedDate->dayOfWeek == 6
        ||   WorkingDayHoliday::whereDate("date",$suggestedDate)->first() != null){
            $suggestedDate = $suggestedDate->addDay();
        }
        return $suggestedDate;
    }


}
