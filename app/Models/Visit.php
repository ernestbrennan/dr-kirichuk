<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visits';

    protected $fillable = [
        'patient_id', 'prescription', 'recommendation', 'date'
    ];
    protected $casts = [
        'date' => 'datetime'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function doctor_private_comment()
    {
        return $this->morphOne(Comment::class, 'commentable')
            ->where('type', Comment::TYPE_VISIT_DOCTOR_PRIVATE);
    }

    public function patient_private_comment()
    {
        return $this->morphOne(Comment::class, 'commentable')
            ->where('type', Comment::TYPE_VISIT_PATIENT_PRIVATE);
    }

    public function doctor_comment()
    {
        return $this->morphOne(Comment::class, 'commentable')
            ->where('type', Comment::TYPE_VISIT_DOCTOR);
    }

    public function scheduled_message()
    {
        return $this->morphOne(ScheduledMessage::class, 'messageable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
