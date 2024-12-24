<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class BankTranslation extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = ['name'];

    public $timestamps = false;
    
    protected $auditInclude = [
        'name'
    ];
  
}
