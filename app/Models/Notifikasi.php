<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasis';

    protected $fillable = ['user_id', 'title', 'body', 'is_read'];
    protected $casts = ['is_read' => 'boolean'];
}
