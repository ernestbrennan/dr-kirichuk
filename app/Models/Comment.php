<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const TYPE_PATIENT_DOCTOR = 'patient_doctor';
    const TYPE_VISIT_DOCTOR = 'visit_doctor';
    const TYPE_VISIT_PATIENT_PRIVATE = 'visit_patient_private';
    const TYPE_VISIT_DOCTOR_PRIVATE = 'visit_doctor_private';

    protected $table = 'comments';

    protected $fillable = [
        'content', 'type'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
