<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Services\Admin\PermissionService;
use Illuminate\Http\Request;

class PermissionCrudController  extends BaseCrudController
{
    protected array $with = ['category'];
    protected string $request = PermissionRequest::class;

    public function __construct(PermissionService $service)
    {
        parent::__construct($service);
    }
}
