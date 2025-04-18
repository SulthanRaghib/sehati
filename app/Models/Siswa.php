<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

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
        'tahun_akademik_id',
        'tahun_masuk',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($siswa) {
            // Hapus user yang terkait dengan siswa ini
            $siswa->user()->forceDelete();
        });

        static::deleted(function ($siswa) {
            // Pastikan siswa benar-benar dihapus dari database
            $siswa->forceDelete();
        });
    }

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

    public function konseling()
    {
        return $this->hasMany(Konseling::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }
}
