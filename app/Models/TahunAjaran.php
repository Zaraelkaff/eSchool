<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    protected $fillable = [
        'tahun_ajaran',
        'tgl_mulai',
        'tgl_selesai'
    ];
    public function kelas()
    {
        return $this->hasMany(Kelas::class,'tahun_ajaran_id','id');
    }
}
