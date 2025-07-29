<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';
    protected $fillable = [
        'mapel', 'pertemuan', 'judul', 'deskripsi'
    ];
    public function kelas_mapel(){
        return $this->belongsTo(KelasMapel::class,'mapel','id');
    }
    public function sub_materi(){
        return $this->hasMany(SubMateri::class,'materi_id', 'id');
    }
}
