<?php

namespace App\Repositories\Eloquent;

use App\Models\TransactionToDo;
use App\Repositories\TransactionToDoRepositoryInterface;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class TransactionToDoRepository extends BaseRepository implements TransactionToDoRepositoryInterface
{
    /**
     * BankRepository constructor.
     * @param TransactionToDo $model
     */
    public function __construct(TransactionToDo $model)
    {
        parent::__construct($model);
    }

    public function getPaymentTransactionToDo($payment_id, $model_id): int
    {
        return $this->model
            ->where('payment_id', $payment_id)
            ->where('id', '!=', $model_id)
            ->where('executed', false)
            ->count();
    }

    public function getTransactionToDoList($perPage, $filters = [], $with = [], $sortKeys = ['id'], $sortDir = ['asc'], $isPaginate = true)
    {
        $query = $this->getToDoTransactionsAsOne();

        // Apply filters
        foreach ($filters as $key => $value) {
            if (in_array($key, ['to_bank_id', 'to_bank_account_number','from_bank_id', 'from_bank_account_number','executed','due_date'])) {
                $query->where($key, $value);
            }
        }

        // Apply sorting
        foreach ($sortKeys as $key => $sortKey) {
            $sortDirection = $sortDir[$key] ?? 'ASC';
            if (in_array($sortKey, ['to_bank_id', 'to_bank_account_number'])) {
                $query->orderBy( $sortKey, $sortDirection);
            } else {
                $query->orderBy( $sortKey, $sortDirection);
            }
        }

        // Eager load relationships
        if (!empty($with)) {
            $query->with($with);
        }

        // Paginate results
        if ($isPaginate)
            return $query->paginate($perPage);
        else
            return $query->get();
    }


    public function getToDoTransactionsAsOne ()
    {
        return TransactionToDo::query();
    }

    public function getALBarakaToDoTransactionsWithoutComission ()
    {
        $all = TransactionToDo::with(['payment','payment.customerPaidBank'])->where("executed",'=',0)
            ->where("type","payment")
            ->get();
        foreach ($all as $transactionToDo ){
                $transactionToDo->real_from_bank_id = $transactionToDo->payment->customerPaidBank->id;

        }
        return $all->groupBy('real_from_bank_id')->map(function ($items) {
            return $items->groupBy('to_bank_id');
        });
    }
    public function getALBarakaToDoCommission ()
    {
       return  TransactionToDo::with(['payment'])
            ->where("type","!=","payment")
            ->where("executed",'=',0)->get();
    }
}
