<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtikelKategori extends Model
{
    protected $table = 'artikel_kategoris';
    protected $fillable = [
        'nama',
        'slug',
    ];

    public function artikel()
    {
        return $this->hasMany(Artikel::class);
    }
}
