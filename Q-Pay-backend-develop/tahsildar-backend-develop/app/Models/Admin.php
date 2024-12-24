<?php

namespace App\Models;

use App\Filters\Admin\HideSuperAdminFilter;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Admin extends BaseModel implements
    AuthorizableContract, AuthenticatableContract
{
    use HasApiTokens, HasFactory, Notifiable, Authenticatable, Authorizable;


    protected $guarded = 'admins';
    /**
     * @var string[]
     */
    protected $fillable = [
        'username',
        'password',
        'role_id'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected array $filters = [
        HideSuperAdminFilter::class
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
