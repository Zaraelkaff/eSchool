<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKelas extends Model
{
    protected $table = 'master_kelas';
    protected $fillable = [
        'nama_kelas',
        'level',
        'is_active'
    ];
    public function kelas()
    {
        return $this->hasMany(Kelas::class,'master_kelas_id','id');
    }
}
