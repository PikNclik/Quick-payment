<?php

namespace App\Services;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Repositories\Eloquent\UserRepository;

class UserService extends BaseService
{
    /**
     * UserService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function block(int $id): ApiSharedMessage
    {
        $user = $this->repository->findById($id);
        if ($user) {
            $updateVaules = [];
            if ($user->active)
                $updateVaules = ['active' => 0];
            else
                $updateVaules = ['active' => 1];
            return new ApiSharedMessage(
                __('success.block', ['model' => "Resource"]),
                $this->repository->update($id, $updateVaules),
                true,
                null,
                200
            );
        } else
            return new ApiSharedMessage(
                __('errors.not_found', ['model' => "Resource"]),
                null,
                false,
                null,
                404
            );
    }

    public function getNewMerchantsCount(): ApiSharedMessage
    {
        return new ApiSharedMessage(
            __('success.index', ['model' => "Resource"]),
            ['count'=>$this->repository->getNewMerchantsCount()],
            true,
            null,
            200
        );
    }

    

}
