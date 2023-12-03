<?php

namespace App\Services;

use App\Repositories\Eloquent\NotificationRepository;

class NotificationService extends BaseService
{
    /**
     * NotificationService constructor.
     * @param NotificationRepository $repository
     */
    public function __construct(NotificationRepository $repository)
    {
        parent::__construct($repository);
    }
}