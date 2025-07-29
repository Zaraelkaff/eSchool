<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMateri extends Model
{
    protected $table = 'sub_materi';
    protected $fillable = [
        'materi_id', 'subjudul', 'deskripsi', 'file'
    ];
    public function materi(){
        return $this->belongsTo(Materi::class, 'materi_id', 'id');
    }
}
