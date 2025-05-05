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
        'no_hp',
        'foto',
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
        'status',
        'is_completed',
    ];

    public function checkCompletion()
    {
        $fields = [
            'nisn' => $this->nisn,
            'nama' => $this->nama,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'agama_id' => $this->agama_id,
            'kelas_id' => $this->kelas_id,
            'no_hp' => $this->no_hp,
            'foto' => $this->foto,
            'nik_ayah' => $this->nik_ayah,
            'nama_ayah' => $this->nama_ayah,
            'tempat_lahir_ayah' => $this->tempat_lahir_ayah,
            'tanggal_lahir_ayah' => $this->tanggal_lahir_ayah,
            'pekerjaan_ayah_id' => $this->pekerjaan_ayah_id,
            'nik_ibu' => $this->nik_ibu,
            'nama_ibu' => $this->nama_ibu,
            'tempat_lahir_ibu' => $this->tempat_lahir_ibu,
            'tanggal_lahir_ibu' => $this->tanggal_lahir_ibu,
            'pekerjaan_ibu_id' => $this->pekerjaan_ibu_id,
        ];

        $emptyFields = [];

        foreach ($fields as $key => $value) {
            if ($value === null || $value === '') {
                $emptyFields[] = $key;
            }
        }

        $this->is_completed = count($emptyFields) === 0;
        $this->save();

        return $emptyFields; // Kembalikan array field yang belum lengkap
    }


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
