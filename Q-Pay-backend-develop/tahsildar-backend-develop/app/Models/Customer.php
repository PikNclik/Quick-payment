<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name','bank_id','bank_account_number','phone'];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
