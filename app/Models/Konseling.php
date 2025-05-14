<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    protected $fillable = [
        'siswa_id',
        'judul',
        'kategori_konseling',
        'isi_konseling',
        'status_id',
        'tanggal_konseling',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function jawaban()
    {
        return $this->hasOne(Jawaban::class);
    }
}
