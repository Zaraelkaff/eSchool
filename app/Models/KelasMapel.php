<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasMapel extends Model
{
    protected $table = 'kelas_mapel';
    protected $fillable = [
        'kelas_id', 'mapel_id', 'pengajar_id'
    ];
    public function pengajar()
    {
        return $this->belongsTo(Staff::class,'pengajar_id','id');
    }

    public function mapel(){
        return $this->belongsTo(Mapel::class,'mapel_id','id');
    }
    
    public function kelas(){
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }

    public function materi(){
        return $this->hasMany(Materi::class, 'mapel','id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class,'kelas_mapel_id','id');
    }
}
