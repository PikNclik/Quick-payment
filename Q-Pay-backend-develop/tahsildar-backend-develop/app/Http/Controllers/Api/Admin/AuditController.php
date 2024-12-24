<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\AuditService;

class AuditController extends BaseController
{
    
    private AuditService $service;
    public function __construct(AuditService $service)
    {
        $this->service=$service;
    }


    public function index(Request $request)
    {
        $filters = $request->all();
        $isPaginate = $request->isPaginate ?: "true";
        return $this->handleSharedMessage(
            $this->service->getAuditData($request->per_page ?? 10, $filters, $request->sort_keys ?? ['id'], $request->sort_dir ?? ['desc'],$isPaginate)
        );
    }

}
