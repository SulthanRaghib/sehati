<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasis';

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'type',
        'is_read',
        'related_id',
        'related_type'
    ];

    protected $casts = ['is_read' => 'boolean'];

    public function related()
    {
        return $this->morphTo();
    }
}
