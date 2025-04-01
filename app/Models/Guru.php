<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($guru) {
            // Hapus user yang terkait dengan guru ini
            $guru->user()->forceDelete();
        });

        static::deleted(function ($guru) {
            // Pastikan guru benar-benar dihapus dari database
            $guru->forceDelete();
        });
    }

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

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
}
