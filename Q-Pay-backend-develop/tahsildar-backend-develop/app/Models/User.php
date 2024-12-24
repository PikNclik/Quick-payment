<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Filters\User\ActivatedFromDateFilter;
use App\Filters\User\ActivatedToDateFilter;
use App\Filters\User\CompletedFilter;
use App\Filters\User\CreatedFromDateFilter;
use App\Filters\User\CreatedToDateFilter;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use OwenIt\Auditing\Contracts\Auditable;

class User extends BaseModel implements
    AuthorizableContract,
    AuthenticatableContract,
    HasMedia,
    Auditable
{
    use HasApiTokens, HasFactory, Notifiable, Authenticatable, Authorizable, InteractsWithMedia, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'active',
        'phone',
        'verification_code',
        'bank_id',
        'bank_account_number',
        'fcm_token',
        'fcm_platform',
        'city_id',
        'logo',
        'email',
        'language',
        'password',
        'webhook_url',
        'reset_password_code',
        "business_name",
        'profession_id',
        "activated_at",
        "qpay_id"

    ];

    protected $auditInclude = [
        'full_name',
        'phone',
        'webhook_url',
        'bank_id',
        'city_id',
        "business_name",
        'profession_id'
    ];
  
    protected $appends = ['completed'];
    protected $hidden = ['verification_code', 'fcm_token', 'fcm_platform', 'password'];


    protected array $filters = [
        ActivatedFromDateFilter::class,
        ActivatedToDateFilter::class,
        CreatedFromDateFilter::class,
        CreatedToDateFilter::class,
        CompletedFilter::class
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function removeCountryCode()
    {
        return substr($this->phone, -9);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function getCompletedAttribute()
    {
        return $this->activated_at ? 'yes' : 'no';
    }
}
