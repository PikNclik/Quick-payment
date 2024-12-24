<?php

namespace App\Repositories\Eloquent;

use App\Models\BankTranslation;

class BankTranslationRepository extends BaseRepository 
{
    /**
     * BankTranslationRepository constructor.
     * @param BankTranslation $model
     */
    public function __construct(BankTranslation $model)
    {
        parent::__construct($model);
    }
}
