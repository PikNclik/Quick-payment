<?php

namespace App\Repositories\Eloquent;

use App\Models\Profession;

class ProfessionRepository extends BaseRepository
{
    /**
     * ProfessionRepository constructor.
     * @param Profession $model
     */
    public function __construct(Profession $model)
    {
        parent::__construct($model);
    }
}
