<?php

namespace App\Models;

use App\Filters\Bank\ActiveFilter;
use App\Filters\Bank\SystemBankDataFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Bank
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Bank newModelQuery()
 * @method static Builder|Bank newQuery()
 * @method static Builder|Bank query()
 * @method static Builder|Bank whereId($value)
 * @method static Builder|Bank whereCreatedAt($value)
 * @method static Builder|Bank whereUpdatedAt($value)
 */
class Bank extends BaseModel implements TranslatableContract, Auditable
{
    use HasFactory, Translatable, \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'active'
    ];
    protected $guarded = [];

    protected $hidden = ['translations'];

    public array $translatedAttributes = ['name'];

    protected $with = ['translations'];

    public $translationForeignKey = 'bank_id';

    protected array $filters = [ActiveFilter::class,SystemBankDataFilter::class];

    public function system_bank_data(): HasMany
    {
        return $this->hasMany(SystemBankData::class);
    }
}
