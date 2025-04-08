<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $table = 'tahun_akademiks';
    protected $fillable = ['periode', 'semester', 'is_active'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'tahun_akademik_id');
    }
}
