<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionCategoryRequest;
use App\Services\Admin\PermissionCategoryService;
use Illuminate\Http\Request;

class PermissionCategoryCrudController extends BaseCrudController
{
    protected string $request = PermissionCategoryRequest::class;


    public function __construct(PermissionCategoryService $service)
    {
        parent::__construct($service);
    }
}
