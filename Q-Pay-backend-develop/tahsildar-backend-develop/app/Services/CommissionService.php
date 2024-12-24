<?php

namespace App\Services;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Repositories\Eloquent\CommissionRepository;

class CommissionService extends BaseService
{
    /**
     * CommissionService constructor.
     * @param CommissionRepository $repository
     */
    public function __construct(CommissionRepository $repository)
    {
        parent::__construct($repository);
    }


      /**
     * @param $payload
     * @return ApiSharedMessage
     */
    public function store($payload): ApiSharedMessage
    {
        $terminalAccountCheck = $this->repository->checkTerminalBank($payload['terminal_bank_id']);
        if ($terminalAccountCheck) {
            return new ApiSharedMessage(
                __('errors.terminal_account_has_commission', ['model' => "Resource"]),
                null,
                false,
                null,
                400
            );
        }
        return new ApiSharedMessage(__('success.store', ['model' => $this->modelName]),
            $this->repository->create($payload),
            true,
            null,
            200
        );
    }

    /**
     * Update By Id
     *
     * @param int $id
     * @param array $payload
     * @param array $options
     * @return ApiSharedMessage
     */
    public function update(int $id, array $payload, array $options = []): ApiSharedMessage
    {
        $terminalAccountCheck = $this->repository->checkTerminalBank($payload['terminal_bank_id'],$id);
        if ($terminalAccountCheck) {
            return new ApiSharedMessage(
                __('errors.terminal_account_has_commission', ['model' => "Resource"]),
                null,
                false,
                null,
                400
            );
        }
        return new ApiSharedMessage(__('success.update', ['model' => $this->modelName]),
            $this->repository->update($id, $payload, $options),
            true,
            null,
            200
        );
    }
}