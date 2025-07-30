<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'absen';
    protected $fillable = [
        'tanggal',
        'kelas_mapel_id',
        'murid_id',
        'status',
        'keterangan'
    ];
    public function murid(){
        return $this-> belongsTo(Murid::class,'murid_id','id');
    }
    
    public function kelas_mapel(){
        return $this-> belongsTo(KelasMapel::class,'kelas_mapel_id','id');
    }
}
