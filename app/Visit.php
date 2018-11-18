<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Visit extends Model
{
    public function logs() {
        return $this->hasMany(Log::class);
    }

    public function trap() {
        return $this->belongsTo(Trap::class);
    }
}
