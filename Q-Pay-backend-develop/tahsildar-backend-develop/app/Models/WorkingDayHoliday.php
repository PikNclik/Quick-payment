<?php

namespace App\Models;

use App\Filters\Admin\CalendarMonthFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class WorkingDayHoliday extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $guarded = [];
    protected array $filters =  [
        CalendarMonthFilter::class
    ];
}
