<?php

namespace App\Models;

use App\Filters\TransactionToDo\ExecutedFilter;
use App\Filters\TransactionToDo\FromBankFilter;
use App\Filters\TransactionToDo\ToBankFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class TransactionToDo extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected array $filters = [FromBankFilter::class,ToBankFilter::class,ExecutedFilter::class];

    public function from_bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class,'from_bank_id');
    }

    public function to_bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class,'to_bank_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class,);
    }
}
