<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajarans';

    protected $fillable = [
        'kode',
        'nama',
        'kkm',
    ];

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'mata_pelajaran_id');
    }

    public function raports()
    {
        return $this->hasMany(Raport::class, 'mata_pelajaran_id');
    }
}
