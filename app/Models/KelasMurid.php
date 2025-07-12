<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasMurid extends Model
{
    protected $table = 'kelas_murid';
    protected $fillable = [
        'murid_id', 'kelas_id'
    ];
}
