<?php

namespace App\Models;

use App\Filters\Payment\BankFilter;
use App\Filters\Payment\CityFilter;
use App\Filters\Payment\FromDateFilter;
use App\Filters\Payment\StatusFilter;
use App\Filters\Payment\ToDateFilter;
use App\Filters\Payment\UserFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $user_id
 * @property int $status
 * @property string $uuid
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
    protected $fillable = [
        'payer_name',
        'payer_mobile_number',
        'amount',
        'details',
        'expiry_date',
        'scheduled_date',
        'user_id',
        'status',
        'paid_at',
        'uuid',
        'token',
        'ref_num',
        'rrn',
        'hash_card',
        'fees_percentage',
        'fees_value'
    ];

    protected array $filters = [UserFilter::class,StatusFilter::class,FromDateFilter::class,ToDateFilter::class,BankFilter::class,CityFilter::class];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
