<?php

namespace App\Http\Controllers\Api\Admin;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\ProfessionRequest;
use App\Models\BusinessDomain;
use App\Models\BusinessType;
use App\Models\Profession;
use App\Services\Admin\ProfessionService;

class ProfessionController  extends BaseCrudController
{
    
     /** @var string */
     protected string $request = ProfessionRequest::class;

    /**
 * PaymentCrudController constructor.
 * @param ProfessionService $service
 */
    public function __construct(ProfessionService $service)
    {
        parent::__construct($service);
    }

    public function getProfessions ()
    {
        return $this->handleSharedMessage(
           new ApiSharedMessage(
               "success.all",
                Profession::all(),
               true,
                null,
                200
            )
        );
    }

    public function getBusinessDomains ()
    {
        return $this->handleSharedMessage(
            new ApiSharedMessage(
                "success.all",
                BusinessDomain::all(),
                true,
                null,
                200
            )
        );
    }
    public function getBusinessTypes ()
    {
        return $this->handleSharedMessage(
            new ApiSharedMessage(
                "success.all",
                BusinessType::all(),
                true,
                null,
                200
            )
        );
    }

}
