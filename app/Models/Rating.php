<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'jawaban_id',
        'siswa_id',
        'rating',
        'komentar',
    ];

    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
