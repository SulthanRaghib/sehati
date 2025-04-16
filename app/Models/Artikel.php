<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikels';
    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'gambar',
        'artikel_kategori_id',
        'user_id',
        'sumber',
        'tanggal_terbit',
        'status',
        'views'
    ];

    public function artikelKategori()
    {
        return $this->belongsTo(ArtikelKategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
