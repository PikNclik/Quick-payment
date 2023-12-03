<?php

namespace App\Definitions;

class RelationTypes
{
    // Used when apply join on table from another join table in the same model.
    const ANOTHER_TO_ANOTHER_MODEL = 'another_to_another_model';
    // Used when apply join on table that used in the other model.
    const OTHER_MODEL = "other_model";
    // Used when apply join table in the same model.
    const OUR_MODEL = 'our_model';

    const STATUS = [
        self::ANOTHER_TO_ANOTHER_MODEL,
        self::OTHER_MODEL,
        self::OUR_MODEL,
    ];
}
