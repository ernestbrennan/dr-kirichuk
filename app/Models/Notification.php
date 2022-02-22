<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const TYPE_PATIENT_REGISTERED = 'patient_registered';
    const TYPE_PATIENT_BIRTHDAY = 'patient_birthday';

    protected $table = 'notifications';

    protected $fillable = [
        'type', 'patient_id', 'is_read'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
