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
        'tgl_lahir',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function kelasMurid()
    {
        return $this->hasMany(KelasMurid::class, 'murid_id');
    }

}
