<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasMapel extends Model
{
    protected $table = 'kelas_mapel';
    protected $fillable = [
        'kelas_id', 'mapel_id', 'pengajar'
    ];
    public function kelas_mapel()
    {
        return $this->belongsTo(Staff::class,'pengajar','id');
    }

    public function mapel(){
        return $this->belongsTo(Mapel::class,'mapel_id','id');
    }
    
    public function kelas(){
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }

    public function materi(){
        return $this->belongsTo(Materi::class, 'mapel','id');
    }
}
