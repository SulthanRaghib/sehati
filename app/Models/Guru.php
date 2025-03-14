<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'gurus';
    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'agama_id',
        'pendidikan_terakhir_id',
    ];

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function pendidikanTerakhir()
    {
        return $this->belongsTo(PendidikanTerakhir::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
