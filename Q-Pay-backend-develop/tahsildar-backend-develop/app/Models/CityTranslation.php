<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CityTranslation extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;
}
