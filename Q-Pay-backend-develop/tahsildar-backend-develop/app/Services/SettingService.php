<?php

namespace App\Services;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Repositories\Eloquent\SettingRepository;

class SettingService extends BaseService
{
    /**
     * SettingService constructor.
     * @param SettingRepository $repository
     */
    public function __construct(SettingRepository $repository)
    {
        parent::__construct($repository);
    }

    public function get_by_key($key): ApiSharedMessage
    {
        return new ApiSharedMessage('',$this->repository->getElementBy('key',$key),true,null,'200');
    }
}
