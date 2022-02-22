<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailingLog extends Model
{
    protected $fillable = [
        'text', 'succeed_count', 'failed_count'
    ];
}
