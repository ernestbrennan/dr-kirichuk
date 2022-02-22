<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledMessage extends Model
{
    protected $table = 'scheduled_messages';

    protected $fillable = [
        'content', 'date', 'type'
    ];

    public function messageable()
    {
        return $this->morphTo();
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
