<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = [
        'kelas_mapel_id',
        'hari',
        'jam_id'
    ];
    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class,'kelas_mapel_id','id');
    }
    public function jam()
    {
        return $this->belongsTo(Jam::class, 'jam_id', 'id');
    }
}
