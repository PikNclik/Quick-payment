<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;


class AdminRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     * @param Admin $model
     */
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

   
}
