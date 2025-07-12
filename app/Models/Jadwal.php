<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'hari',
        'jam_mulai',
        'jam_selesai'
    ];
    public function mapel()
    {
        return $this->belongsTo(Mapel::class,'mapel_id','id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }
}
