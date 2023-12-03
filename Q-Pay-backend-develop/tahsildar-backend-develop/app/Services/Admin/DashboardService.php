<?php

namespace App\Services\Admin;

use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Eloquent\UserRepository;

class DashboardService
{
    protected UserRepository $userRepository;
    protected PaymentRepository $paymentRepository;

    public function __construct(UserRepository $userRepository,
                                PaymentRepository $paymentRepository)
    {
        $this->userRepository = $userRepository;
        $this->paymentRepository = $paymentRepository;
    }


    public function getStatistics($date): array
    {
        $data['merchants'] = $this->userRepository->getStatistics($date);
        $data['transactions'] = $this->paymentRepository->getStatics($date);
        return $data;
    }

    public function getChart($start,$end,$user_id = null)
    {
    return $this->paymentRepository->getLineChart($start,$end,$user_id);

    }
}
