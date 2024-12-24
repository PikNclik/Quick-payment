<?php

namespace App\Models;

use App\Filters\SystemBank\BankNumberNotNullFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemBankData extends BaseModel
{
    use HasFactory;

    protected $fillable = ['bank_account_number','bank_id','default_transaction'];

    protected array $filters = [BankNumberNotNullFilter::class];
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

}
