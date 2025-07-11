<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $table = 'murid';
    
    protected $fillable = [
        'NIK',
        'NIS',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'agama',
        'alamat',
        'notelp',
        'nama_ayah',
        'nama_ibu',
        'tgl_masuk',
        'tgl_keluar',
        'users_id',
        'is_active'
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_murid', 'murid_id', 'kelas_id')->withTimestamps();
    }

    public function absen()
    {
        return $this->hasMany(Absen::class,'murid_id','id');
    }
}
