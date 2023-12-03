<?php

namespace App\Http\Controllers\Api\Admin;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StatisticsRrequest;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function getStatistics(StatisticsRrequest $request)
    {
        return $this->handleSharedMessage(
            new ApiSharedMessage(
                __('success.index'),
                $this->dashboardService->getStatistics($request->validated()),
                true,
                null,
                200));
    }

    public function getStatisticsCharts(StatisticsRrequest $request)
    {
        $request = $request->validated();
        return $this->handleSharedMessage(
            new ApiSharedMessage(
                __('success.index'),
                $this->dashboardService->getChart($request['start'],$request['end'],$request['user_id'] ?? null),
                true,
                null,
                200));
    }
}
