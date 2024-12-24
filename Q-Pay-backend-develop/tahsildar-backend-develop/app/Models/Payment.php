<?php

namespace App\Models;

use App\Filters\Payment\BankFilter;
use App\Filters\Payment\CityFilter;
use App\Filters\Payment\FromDateFilter;
use App\Filters\Payment\NotChildFilter;
use App\Filters\Payment\StatusFilter;
use App\Filters\Payment\ToDateFilter;
use App\Filters\Payment\TypeFilter;
use App\Filters\Payment\UserFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $user_id
 * @property int $status
 * @property string $uuid
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereCreatedAt($value)
 * @method static Builder|Payment whereUpdatedAt($value)
 */
class Payment extends BaseModel
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    protected array $filters = [
        UserFilter::class,
        StatusFilter::class,
        FromDateFilter::class,
        ToDateFilter::class,
        BankFilter::class,
        CityFilter::class,
        TypeFilter::class,
        NotChildFilter::class
    ];

//    protected static function booted()
//    {
//        static::addGlobalScope('remove_children', function (Builder $builder) {
//            $builder->whereNull('parent_payment_id');
//        });
//    }
    protected $with = ['children'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function terminal_bank(): BelongsTo
    {
        return $this->belongsTo(TerminalBank::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Payment::class,'parent_payment_id','id');
    }

    public function transactionToDo(): HasOne
    {
        return $this->hasOne(TransactionToDo::class);
    }

    public function customerPaidBank(): BelongsTo
    {
        return $this->belongsTo(Bank::class,'iin_number','iin_number');
    }

    public function getCreatedAtAttribute($value)
    {
        $value = Carbon::parse($value)->setTimezone('Asia/Riyadh')->toDateTimeString();
       return $value;
    }
//    public function setExpiryDateAttribute($value)
//    {
//        $this->attributes['expiry_date'] = Carbon::parse($value)->endOfDay();
//    }
}
