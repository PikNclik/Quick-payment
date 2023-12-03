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
        if ($user)
            return new ApiSharedMessage(__('success.block', ['model' => "Resource"]),
                $this->repository->update($id, ['active' => 0]),
                true,
                null,
                200
            );
        else
            return new ApiSharedMessage(__('errors.not_found', ['model' => "Resource"]),
                null,
                false,
                null,
                404
            );
    }
}
