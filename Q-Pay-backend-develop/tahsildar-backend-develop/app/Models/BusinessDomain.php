<?php

namespace App\Models;

use App\Filters\BusinessDomain\BusinessTypeFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDomain extends BaseModel
{
    use HasFactory;

    protected $with = ['businessType'];
    protected array $filters = [
        BusinessTypeFilter::class
    ];
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }
}
