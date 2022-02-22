<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'api_token', 'fcm_token'
    ];

    public function getAuthIdentifier()
    {
        return 'name';
    }

    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
}
