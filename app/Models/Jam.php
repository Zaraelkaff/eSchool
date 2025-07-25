<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jam extends Model
{
    protected $table = 'jam';
    protected $fillable = [
        'jam_mulai',
        'jam_selesai',
        'is_active'
    ];
    protected $casts = [
        'jam_mulai' => 'datetime:H:i:s',
        'jam_selesai' => 'datetime:H:i:s',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'jam_id', 'id');
    }
}
