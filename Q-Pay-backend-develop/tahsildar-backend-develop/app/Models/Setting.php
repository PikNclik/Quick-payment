<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class Setting extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = ['key','value'];

    static function getValue ($key)
    {
            $setting = Setting::where("key",$key)->first();
            return $setting?->value;
    }
}
