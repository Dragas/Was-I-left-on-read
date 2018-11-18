<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {


    public function visit() {
        return $this->belongsTo(Visit::class);
    }
}
