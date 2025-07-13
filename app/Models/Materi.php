<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';
    protected $fillable = [
        'mapel', 'pertemuan', 'judul', 'file'
    ];
    public function kelas_mapel(){
        return $this->belongsTo(KelasMapel::class,'mapel','id');
    }
}
