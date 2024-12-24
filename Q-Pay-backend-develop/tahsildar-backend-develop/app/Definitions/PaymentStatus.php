<?php

namespace App\Definitions;

class PaymentStatus
{
    const PENDING = 1;
    const SCHEDULED = 2;
    const PAID = 3;
    const EXPIRED = 4;
    const CANCELLED = 5;
    const REFUNDED = 6;
    const SETTLED = 7;

    const STATUSES = [self::PENDING,self::SCHEDULED,self::PAID,self::EXPIRED,self::CANCELLED,self::REFUNDED,self::SETTLED];
    const NOTIFICATION_STATUSES = [self::PENDING,self::PAID,self::EXPIRED,self::CANCELLED];
    const APPROVED_PAID_STATUSES = [self::PENDING];
    const CAN_CANCELED_STATUSES = [self::PENDING,self::EXPIRED,self::SCHEDULED];


    const STATUSES_NAME = [
        self::PENDING => "Pending",
        self::SCHEDULED => "Scheduled",
        self::PAID => "Paid",
        self::EXPIRED => "Expired",
        self::CANCELLED => "Cancelled",
        self::REFUNDED => "Refunded",
        self::SETTLED => 'Settled'
    ];

}
