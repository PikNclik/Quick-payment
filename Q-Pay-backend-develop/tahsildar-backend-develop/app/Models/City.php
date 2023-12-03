<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

/**
 * App\Models\City
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereUpdatedAt($value)
 */
class City extends BaseModel implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $guarded = [];

    protected $hidden = ['translations'];

    public array $translatedAttributes = ['name'];

    protected $with = ['translations'];

    public $translationForeignKey = 'city_id';
}
