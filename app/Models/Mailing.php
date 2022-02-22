<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    const TYPE_BIRTHDAY = 'birthday';

    protected $fillable = [
        'content', 'date', 'type', 'file_meta'
    ];

    protected $casts = [
        'file_meta' => 'json'
    ];

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
