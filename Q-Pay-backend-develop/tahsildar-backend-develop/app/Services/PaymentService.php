<?php

namespace App\Services;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Definitions\PaymentStatus;
use App\Repositories\Eloquent\PaymentRepository;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PaymentService extends BaseService
{
    /**
     * PaymentService constructor.
     * @param PaymentRepository $repository
     */
    public function __construct(PaymentRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getSumAmount($user_id,$date): ApiSharedMessage
    {
        $data['paid'] = $this->repository->getSumAmountByStatus($user_id,$date,PaymentStatus::PAID);
        $data['pending'] = $this->repository->getSumAmountByStatus($user_id,$date,PaymentStatus::PENDING);
        return new ApiSharedMessage(__('success.all', ['model' => $this->modelName]),
            $data,
            true,
            null,
            200
        );
    }

    public function export($exportClass,
                           array  $columns = [],
                           array  $relations = [],
                           int    $length = 10,
                           array  $sortKeys = ['id'],
                           array  $sortDir = ['asc'],
                           array  $filters = [],
                           array  $searchableFields = [],
                           string $search = null,
                           bool   $searchInRelation = false,
                           int    $withTrash = 0,
                           array  $joinsArray = [],
                           bool   $isPaginate = true): BinaryFileResponse
    {
        $result = $this->repository->all($columns, $relations, $length, $sortKeys, $sortDir, $filters, $searchableFields, $search, $searchInRelation, $withTrash, $joinsArray,$isPaginate);
        return Excel::download(new $exportClass($result), $this->modelName . '.xlsx');
    }

    public function cancel(int $id): ApiSharedMessage
    {
        $payment = $this->repository->findById($id);
        if (!$payment) {
            return new ApiSharedMessage(__('errors.not_found', ['model' => "Resource"]),
                null,
                false,
                null,
                404
            );
        }
        $status = null;

        if (in_array($payment->status, PaymentStatus::CAN_CANCELED_STATUSES)) {
           $status = PaymentStatus::CANCELLED;
        }
        elseif ($payment->status == PaymentStatus::PAID) {
            $status = PaymentStatus::REFUNDED;
        }

        if ($status)
        {
            return new ApiSharedMessage(__('success.cancel', ['model' => "Resource"]),
                $this->repository->update($id, ['status' => $status]),
                true,
                null,
                200
            );
        }
        else
        {
            return new ApiSharedMessage(__('errors.not_allowed', ['model' => "Resource"]),
                null,
                false,
                null,
                404
            );
        }
    }

    public function getByUuid(string $uuid)
    {
        return $this->repository->getElementBy('uuid',$uuid);
    }

    /**
     * @param $import_class
     * @param $file
     * @return ApiSharedMessage
     */
    public function import($import_class, $file): ApiSharedMessage
    {
        $import_class = resolve($import_class);
        $result = Excel::import(new $import_class(),$file);

        return new ApiSharedMessage(__('success.import', ['model' => "Payment"]),
            $result,
            true,
            null,
            200
        );
    }
}
