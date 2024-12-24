<?php

namespace App\Definitions;

class CommissionTypes
{
    const IGNORE = 'ignore';
    const DIRECT = 'direct';
    const INDIRECT = 'indirect';

    const TYPES = [
        self::IGNORE,
        self::DIRECT,
        self::INDIRECT
    ];
}
