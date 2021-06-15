<?php

namespace App\Domain\User;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Domain\User\User
 *
 * @property int $id
 * @property string $name
 * @property string $login_id
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $email_verification_code
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static Builder|User byEmailVerificationCode(string $code)
 * @method static Builder|User byLoginId(string $loginId)
 * @method static \Database\Factories\Domain\User\UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerificationCode($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLoginId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const MAX_EMAIL_LENGTH = 255;
    const MAX_LOGIN_ID_LENGTH = 30;
    const MAX_PASSWORD_LENGTH = 1000;
    const MIN_PASSWORD_LENGTH = 8;

    const EMAIL_VERIFICATION_CODE_LIFE_TIME_MIN = 24 * 60;

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
        'email_verification_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function generateEmailVerificationCode(): string
    {
        return Str::random(40);
    }


    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    public function scopeByLoginId(Builder $builder, string $loginId)
    {
        return $builder->where('login_id', $loginId);
    }

    public function scopeByEmailVerificationCode(Builder $builder, string $code)
    {
        return $builder
            ->where('email_verification_code', $code)
            ->where('created_at', '>=', Carbon::now()->subMinutes(self::EMAIL_VERIFICATION_CODE_LIFE_TIME_MIN)->format('Y-m-d H:i:s'));
    }
}
