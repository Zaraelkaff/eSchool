<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $fillable = [
        'judul',
        'isi',
        'flyer',
        'tgl_publish',
        'is_active'
    ];
}
