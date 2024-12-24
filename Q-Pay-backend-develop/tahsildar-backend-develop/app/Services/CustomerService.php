<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Common\SharedMessages\ApiSharedMessage;
use Exception;

class CustomerService extends BaseService
{
    private UserRepository $userRepository;
    /**
     * BankService constructor.
     * @param CustomerRepository $repository
     */
    public function __construct(CustomerRepository $repository, UserRepository $userRepository)
    {
        parent::__construct($repository);
        $this->userRepository=$userRepository;
    }


    public function getOrCreateCustomerByPhone($payload): Model|Builder
    {
        return $this->repository->updateOrCreate($payload, $payload);
    }


    public function extractCustomer(array &$payload): void
    {
        if (!isset($payload['qpay_id'])) {
            $customerPayload = ['name' => $payload['payer_name'], 'phone' => $payload['payer_mobile_number']];
            $payload['customer_id'] = $this->getOrCreateCustomerByPhone($customerPayload)->id;
            unset($payload['payer_name']);
            unset($payload['payer_mobile_number']);
        } else {

            $merchants = $this->userRepository->getBy('qpay_id', $payload['qpay_id']);
            if (count($merchants) == 0)
                throw new Exception('Not found');
            $merchant=$merchants[0];
            $customerPayload = ['name' => $merchant->full_name, 'phone' => $merchant->removeCountryCode()];
            $payload['customer_id'] = $this->getOrCreateCustomerByPhone($customerPayload)->id;
            unset($payload['payer_name']);
            unset($payload['payer_mobile_number']);
            unset($payload['qpay_id']);
        }
    }

    public function export(
        $exportClass,
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
        bool   $isPaginate = true
    ): BinaryFileResponse {
        $result = $this->repository->all($columns, $relations, $length, $sortKeys, $sortDir, $filters, $searchableFields, $search, $searchInRelation, $withTrash, $joinsArray, $isPaginate);
        return Excel::download(new $exportClass($result), $this->modelName . '.xlsx');
    }
}
