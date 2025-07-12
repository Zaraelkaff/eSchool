<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasMapel extends Model
{
    protected $table = 'kelas_mapel';
    protected $fillable = [
        'kelas_id', 'mapel_id', 'pengajar'
    ];
    public function pengajar()
    {
        return $this->belongsTo(Staff::class,'pengajar','id');
    }
}
