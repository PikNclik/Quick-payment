<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\SettingRequest;
use App\Services\SettingService;

class SettingController extends BaseCrudController
{
    protected string $request = SettingRequest::class;

    public function __construct(SettingService $service)
    {
        parent::__construct($service);
    }
}
