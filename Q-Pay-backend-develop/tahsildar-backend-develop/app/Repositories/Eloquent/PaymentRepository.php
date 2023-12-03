<?php

namespace App\Repositories\Eloquent;

use App\Definitions\PaymentStatus;
use App\Models\BaseModel;
use App\Repositories\PaymentRepositoryInterface;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    /**
     * PaymentRepository constructor.
     * @param Payment $model
     * @param SettingRepository $settingRepository
     */
    public function __construct(Payment $model,private SettingRepository $settingRepository)
    {
        parent::__construct($model);
    }

    /**
     * @param null $user_id
     * @param $date
     * @param $status
     * @return array
     */
    public function getSumAmountByStatus($user_id ,$date,$status): array
    {
        $query =  $this->model->where('status',$status)
                            ->whereYear('created_at',$date['year'])
                            ->whereMonth('created_at',$date['month']);
        if ($user_id)
        {
            $query->where('user_id',$user_id);
        }
        $total_amount =  $query->sum('amount');

        return ['total_amount' => $total_amount];
    }

    public function getStatics($date)
    {
        $query = $this->model->query();
        if (!empty($date['date'])) {
            $date = Carbon::createFromFormat('Y-m-d', $date['date']);
            $query->whereYear('created_at', '=', $date->year)
            ->whereMonth('created_at', '=', $date->month);

        }
        $data['total_transactions'] = $query->count();
        $paid_value = clone $query;
        $data['paid_value'] = $paid_value->where('status', PaymentStatus::PAID)->sum('amount');
        $data['pending_value'] = $query->where('status', PaymentStatus::PENDING)->sum('amount');
        return $data;
    }

    public function getExpired(): Collection|array
    {
        return $this->model->query()
            ->where('status',PaymentStatus::PENDING)
            ->where('expiry_date','<',date("Y-m-d H:i:s"))
            ->get('id');
    }

    public function getScheduled(): Collection|array
    {
        return $this->model->query()->with('user')
            ->where('status',PaymentStatus::SCHEDULED)
            ->where('scheduled_date','<',date("Y-m-d H:i:s"))
            ->get();
    }

    public function create(array $payload): ?BaseModel
    {
        $fees = $this->settingRepository->getElementBy('key','fees_percentage');
        if ($fees)
            $fees_percentage = $fees->value;
        else
            $fees_percentage = 10;

        $payload['uuid'] = Str::uuid()->toString();
        $payload['fees_percentage'] = $fees_percentage;
        $payload['fees_value'] = ($payload['amount'] * $fees_percentage) / 100;
        return parent::create($payload);
    }

    public function getLineChart($start, $end,$user_id = null): array
    {
        $group_by = [
            'day' => 'DAY(created_at) as date',
            'month' => 'MONTH(created_at) as date',
            'year' => 'YEAR(created_at) as date'
        ];
        $datesResult = generateDateRange($start, $end);
        $ranges = $datesResult['range'];
        $per = $datesResult['per'];

        $query =  $this->model->query()
            ->select(
                DB::raw($group_by[$per]),
                DB::raw('count(*) as count'),
                DB::raw('sum(amount) as total'),
            )
            ->where('status',PaymentStatus::PAID)
            ->whereDate('created_at','>=',$start)
            ->whereDate('created_at','<=',$end);

        if ($user_id) $query->where('user_id', $user_id);

        $query = $query
            ->groupBy('date')
            ->get();


        $countData = [];
        $totalData = [];
        foreach ($ranges as $element) {
            $sameDateIndex = null;
            foreach ($query as $key => $item) {
                if ($item->date == $element) {
                    $sameDateIndex = $key;
                }
            }
            $countData[] = ["name" => $element, "value" => !is_null($sameDateIndex) ? $query[$sameDateIndex]->count : 0];
            $totalData[] = ["name" => $element, "value" => !is_null($sameDateIndex) ? $query[$sameDateIndex]->total : 0];
        }
        return ['totalData' => $totalData, 'countData' => $countData];
    }


}
