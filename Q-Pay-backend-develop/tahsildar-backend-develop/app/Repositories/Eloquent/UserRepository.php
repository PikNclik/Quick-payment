<?php

namespace App\Repositories\Eloquent;

use App\Models\Payment;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getStatistics($date)
    {
        $query = $this->model->query();
        $date = $date ? Carbon::createFromFormat('Y-m-d', $date['date']) : Carbon::now();
        $data['total_merchants'] = $query->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();
        $query->withCount(['payments' => function ($query) use ($date) {
            $query->whereYear('created_at', $date->year)->whereMonth('created_at', $date->month);
        }]);
        $data['total_active_merchants'] = $query->whereHas('payments', function ($query) use ($date) {
            $query->whereYear('created_at', $date->year)->whereMonth('created_at', $date->month);
        })->count();
        return $data;
    }
}
