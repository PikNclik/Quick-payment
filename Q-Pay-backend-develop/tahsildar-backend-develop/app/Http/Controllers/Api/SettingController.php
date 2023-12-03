<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;

class SettingController extends BaseController
{
    /**
     * SettingController constructor.
     * @param SettingService $service
     */
    public function __construct(private SettingService $service)
    {
    }

    public function get_by_key($key): JsonResponse
    {
        return $this->handleSharedMessage($this->service->get_by_key($key));
    }
}
