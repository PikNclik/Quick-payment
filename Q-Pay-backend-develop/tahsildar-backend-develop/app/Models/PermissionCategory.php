<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionCategory extends BaseModel
{
    use HasFactory;
    protected $table = 'permission_category';
    protected $fillable = ['name'];
    public $timestamps = true;


    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

}
