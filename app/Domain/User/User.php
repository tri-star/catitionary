<?php

namespace App\Domain\User;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const MAX_EMAIL_LENGTH = 255;
    const MAX_LOGIN_ID_LENGTH = 30;
    const MAX_PASSWORD_LENGTH = 1000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'login_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    public function scopeByLoginId(Builder $builder, string $loginId)
    {
        return $builder->where('login_id', $loginId);
    }
}
