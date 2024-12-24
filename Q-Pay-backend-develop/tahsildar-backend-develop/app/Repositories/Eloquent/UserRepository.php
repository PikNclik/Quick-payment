<?php

namespace App\Repositories\Eloquent;

use App\Models\Payment;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Services\Facade\TranslationServiceFacade as TranslationService;
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

    
    /**
     * @param int $modelId
     * @param array $payload
     * @param array $option
     * @return BaseModel|null
     */
    public function update(int $modelId, array $payload, array $option = [])
    {
        $model = $this->findById($modelId);

        if(!$model->profession_id && !$model->activated_at && isset($payload['profession_id']))
            $payload['activated_at']=now();
        $payload = TranslationService::getAllTranslationKey($this->model->translatedAttributes ?? [], $payload);

        //Get Many To Many relations Data from Payload.
        $manyToManyRelationsData = $this->getModelRelations($payload);

      
        if (!$this->model->translatedAttributes) {
            unset($payload['en']);
            unset($payload['ar']);
        }

        $model->update($payload, $option);

        //Sync every(many to many) relation with its data from payload.
        foreach ($manyToManyRelationsData as $key => $value)
            $model->{$key}()->sync($value);

        

        return $this->findById($modelId, ['*'], [], [], [], false);
    }
    
    public function getStatistics($date)
    {
        $query = $this->model->query();
        $fromDate = $date && $date['from_date'] ? Carbon::createFromFormat('Y-m-d', $date['from_date'])->startOfDay()->format('Y-m-d H:i:s') : Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $toDate = $date && $date['to_date'] ? Carbon::createFromFormat('Y-m-d', $date['to_date'])->endOfDay()->format('Y-m-d H:i:s') : Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        $data['total_merchants'] = $query->whereDate('created_at','>=',$fromDate)
            ->whereDate('created_at','<=',$toDate)
            ->count();
        $query->withCount(['payments' => function ($query) use ($fromDate,$toDate) {
            $query->whereDate('created_at','>=',$fromDate)
            ->whereDate('created_at','<=',$toDate);
        }]);
        $data['total_active_merchants'] = $query->whereHas('payments', function ($query) use ($fromDate,$toDate) {
            $query->whereDate('created_at','>=',$fromDate)
            ->whereDate('created_at','<=',$toDate);
        })->count();
        return $data;
    }

    public function getNewMerchantsCount()
    {
        return $this->model->query()->whereNull('activated_at')->count();
       
    }
}
