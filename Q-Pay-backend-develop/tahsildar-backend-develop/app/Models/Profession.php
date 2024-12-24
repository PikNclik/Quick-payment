<?php

namespace App\Models;

use App\Filters\Profission\BusinessDomainFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends BaseModel
{
    use HasFactory;

    protected $with = ['businessDomain'];
    protected array $filters = [
        BusinessDomainFilter::class
    ];
    public function businessDomain()
    {
        return $this->belongsTo(BusinessDomain::class);
    }

}
