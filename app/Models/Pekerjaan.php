<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $table = 'pekerjaan';
    protected $fillable = ['nama'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
