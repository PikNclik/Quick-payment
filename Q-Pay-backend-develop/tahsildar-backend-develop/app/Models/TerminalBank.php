<?php

namespace App\Models;

use App\Filters\TerminalBank\BankFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class TerminalBank extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'id','terminal','bank_id','bank_account_number','active'
    ];
    
    protected $fillable = ['terminal', 'bank_id', 'bank_account_number', 'active'];
    protected array $filters = [
        BankFilter::class
    ];
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->active) {
                static::where('id', '!=', $model->id)->update(['active' => false]);
            } else {
                $activeCount = static::where('id', '!=', $model->id)->where('active', true)->count();
                if ($activeCount == 0)
                    $model->active = true;
            }
        });
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }


    public function internal_commission(): BelongsTo
    {
        return $this->belongsTo(Commission::class,'internal_commission_id');
    }

    public function external_commission(): BelongsTo
    {
        return $this->belongsTo(Commission::class,'external_commission_id');
    }

}
