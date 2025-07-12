<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public function mengajar()
    {
        return $this->hasMany(KelasMapel::class,'pengajar','id');
    }
}
