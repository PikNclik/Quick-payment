<?php

namespace App\Models;

use App\Filters\Notification\UserFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

/**
 * App\Models\Notification
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Notification newModelQuery()
 * @method static Builder|Notification newQuery()
 * @method static Builder|Notification query()
 * @method static Builder|Notification whereId($value)
 * @method static Builder|Notification whereCreatedAt($value)
 * @method static Builder|Notification whereUpdatedAt($value)
 */
class Notification extends BaseModel
{
    use HasFactory;

    protected $table = 'notifications';

    protected array $filters = [UserFilter::class];

    protected $keyType = 'string';
}
