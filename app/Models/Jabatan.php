<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $fillable = [
        'nama_jabatan',
        'is_active'
    ];
    public function jabatan_staff(){
        return $this->hasMany(JabatanStaff::class,'jabatan_id','id');
    }
}
