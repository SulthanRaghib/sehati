<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKonseling extends Model
{
    protected $table = 'kategori_konselings';
    protected $fillable = [
        'nama_kategori',
        'contoh_kategori',
    ];

    public function konseling()
    {
        return $this->hasMany(Konseling::class);
    }
}
