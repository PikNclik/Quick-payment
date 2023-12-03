<?php

namespace App\Models;

use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;

/**
 * Class TempMedia
 * @package App\Models
 *
 * @mixin Builder
 */
class TempMedia extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
}
