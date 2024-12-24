<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\CustomerExport;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\CustomerRequest;
use App\Http\Requests\Admin\WorkingDayHolidayRequest;
use App\Services\CustomerService;
use App\Services\WorkingDayHolidayService;

class WorkingDayHolidaysController extends BaseCrudController
{
    protected string $request = WorkingDayHolidayRequest::class;


    public function __construct(WorkingDayHolidayService $service)
    {
        parent::__construct($service);
    }
}
