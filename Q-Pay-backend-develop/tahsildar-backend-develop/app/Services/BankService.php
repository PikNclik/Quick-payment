<?php

namespace App\Services;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Models\BaseModel;
use App\Repositories\Eloquent\BankRepository;

class BankService extends BaseService
{
    /**
     * BankService constructor.
     * @param BankRepository $repository
     */
    public function __construct(BankRepository $repository)
    {
        parent::__construct($repository);
    }

    public function viewAdmin($id): ApiSharedMessage
    {
        return new ApiSharedMessage(__('success.get', ['model' => $this->modelName]),
            $this->repository->findById($id)->makeVisible('translations'),
            true,
            null,
            200
        );
    }
}
