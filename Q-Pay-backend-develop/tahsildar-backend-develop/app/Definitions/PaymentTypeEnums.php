<?php

namespace App\Definitions;

class PaymentTypeEnums
{
    const PAYMENT = 'payment';
    const TRANSFER = 'transfer';

    const TYPES = [
        self::PAYMENT,
        self::TRANSFER
    ];
}
