<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswas';
    protected $fillable = [
        'nisn',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'agama_id',
        'kelas_id',
        'nik_ayah',
        'nama_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'pekerjaan_ayah_id',
        'nik_ibu',
        'nama_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'pekerjaan_ibu_id',
    ];

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pekerjaanAyah()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_ayah_id');
    }

    public function pekerjaanIbu()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_ibu_id');
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
