<?php

namespace App\Definitions;

class JoinTypes
{
    const RIGHT_OUTER_JOIN = 'rightJoin';
    const CROSS_JOIN = 'crossJoin';
    const LEFT_JOIN = "leftJoin";
    const JOIN = "join";

    const STATUS = [
        self::RIGHT_OUTER_JOIN,
        self::CROSS_JOIN,
        self::LEFT_JOIN,
        self::JOIN,
    ];
}
