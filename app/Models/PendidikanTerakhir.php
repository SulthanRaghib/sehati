<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendidikanTerakhir extends Model
{
    protected $table = 'pendidikan_terakhir';
    protected $fillable = ['nama'];

    public function guru()
    {
        return $this->hasMany(Guru::class);
    }
}
