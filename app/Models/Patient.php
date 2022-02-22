<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Patient extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    protected $username = 'phone';

    protected $table = 'patients';

    protected $fillable = [
        'first_name', 'last_name', 'phone', 'verify_code', 'birthday',  'registered_at', 'last_login_at',
    ];
    protected $casts = [
        'birthday' => 'datetime',
        'registered_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    protected $hidden = [
        'verify_code'
    ];

    protected static function boot()
    {
        parent::boot();

//        static::addGlobalScope('last_visit_at', function (Builder $builder) {
//            $builder->selectRaw(DB::raw('(SELECT max(date) FROM visits WHERE patient_id = patients.id ) as last_visit_at'));
//        });
    }

    public static function getByPhone(string $phone)
    {
        return self::where('phone', $phone)->first();
    }

    public static function getByVerifyCode(string $code)
    {
        return self::where('verify_code', $code)->first();
    }

    public function avatar()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scheduled_messages()
    {
        return $this->morphMany(ScheduledMessage::class, 'messageable');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function last_visit()
    {
        return $this->hasOne(Visit::class)->orderBy('date', 'desc');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'patient_city', 'patient_id', 'city_id');
    }

    public function doctor_comment()
    {
        return $this->morphOne(Comment::class, 'commentable')
            ->where('type', Comment::TYPE_PATIENT_DOCTOR);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function hasVerifiedEmail()
    {
        return ! is_null($this->phone_verified_at);
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
