<?php

namespace App\Models;

use App\Filters\Role\HideSuperAdminFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name'];
    public $timestamps = true;

    
    protected array $filters = [
        HideSuperAdminFilter::class
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }
}
