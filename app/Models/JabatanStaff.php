<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanStaff extends Model
{
    protected $table = 'jabatan_staff';
    protected $fillable = [
        'staff_id',
        'jabatan_id',
        'tgl_mulai',
        'tgl_selesai',
        'is_active'
    ];
    public function staff(){
        return $this->belongsTo(Staff::class,'staff_id','id');
    }
    public function jabatan(){
        return $this->belongsTo(Jabatan::class,'jabatan_id','id');
    }
}
