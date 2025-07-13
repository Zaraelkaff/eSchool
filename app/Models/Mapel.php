<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $fillable = [
        'nama_mapel',
        'is_active'
    ];
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class,'mapel_id','id');
    }

    public function kelas_mapel(){
        return $this->hasMany(KelasMapel::class,'mapel_id','id');
    }
}
