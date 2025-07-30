<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = [
        'master_kelas_id',
        'wali_kelas_id',
        'tahun_ajaran_id',
        'is_active'
    ];
    public function murid()
    {
        return $this->belongsToMany(Murid::class, 'kelas_murid');
    }
    public function walikelas()
    {
        return $this->belongsTo(Staff::class, 'wali_kelas_id', 'id');
    }
    public function master_kelas()
    {
        return $this->belongsTo(MasterKelas::class, 'master_kelas_id', 'id');
    }
    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class,'kelas_id','id');
    }
    public function kelasMapel()
    {
        return $this->hasMany(KelasMapel::class, 'kelas_id');
    }
}
