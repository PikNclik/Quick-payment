<?php

namespace App\Filters\Notification;

use App\Filters\Types\ValueFilter;;

class UserFilter extends ValueFilter
{
    public function __construct()
    {
        parent::__construct('notifiable_id', '=');
    }

}
