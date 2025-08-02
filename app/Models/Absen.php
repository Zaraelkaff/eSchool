<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'absen';
    protected $fillable = [
        'tanggal',
        'kelas_id',
        'murid_id',
        'status',
        'keterangan'
    ];
    protected $casts = [
        'tanggal' => 'datetime:Y-m-d',
    ];
    public function murid(){
        return $this-> belongsTo(Murid::class,'murid_id','id');
    }
    
    public function kelas(){
        return $this-> belongsTo(Kelas::class,'kelas_id','id');
    }
}
