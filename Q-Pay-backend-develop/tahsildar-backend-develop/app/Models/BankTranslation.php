<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankTranslation extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;
}
