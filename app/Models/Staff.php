<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $fillable = [
        'NIK',
        'nama',
        'gelar_depan',
        'gelar_belakang',
        'jenis_kelamin',
        'tgl_lahir',
        'alamat',
        'notelp',
        'lulusan',
        'tgl_masuk',
        'tgl_keluar',
        'users_id',
        'is_active'
    ];
    public function kelas_mapel()
    {
        return $this->hasMany(KelasMapel::class,'pengajar_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class,'wali_kelas_id','id');
    }
    public function jabatan_staff(){
        return $this->hasMany(JabatanStaff::class,'staff_id','id');
    }
}
