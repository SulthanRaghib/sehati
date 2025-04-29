<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $fillable = [
        'konseling_id',
        'guru_id',
        'isi_jawaban',
        'tanggal_jawaban',
    ];

    public function konseling()
    {
        return $this->belongsTo(Konseling::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function notifikasi()
    {
        return $this->morphOne(Notifikasi::class, 'related');
    }

    public function ratings()
    {
        return $this->hasOne(Rating::class);
    }
}
