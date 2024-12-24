<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends BaseModel
{
    use HasFactory;
    protected $fillable = ['name','category_id'];
    public $timestamps = true;
    protected $appends = ['category_name'];
    public function category()
    {
        return $this->belongsTo(PermissionCategory::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : null;
    }

}
