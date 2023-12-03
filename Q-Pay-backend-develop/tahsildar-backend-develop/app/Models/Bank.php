<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

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
class Bank extends BaseModel implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $guarded = [];

    protected $hidden = ['translations'];

    public array $translatedAttributes = ['name'];

    protected $with = ['translations'];

    public $translationForeignKey = 'bank_id';

}
