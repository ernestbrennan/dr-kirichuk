<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'extension', 'name', 'hash_name', 'path', 'size', 'url', 'fileable_type', 'fileable_id'
    ];
    protected $hidden = ['fileable_type', "fileable_id"];

    public function fileable()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();
    }

    public function scopeDetach($query)
    {
        if ($files = $query->get()){
            $files->each->update([
                'fileable_type' => null,
                'fileable_id' => null,
            ]);
        }
    }
}
