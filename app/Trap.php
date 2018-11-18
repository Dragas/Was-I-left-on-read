<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ziogas
 * Date: 2018-11-18
 * Time: 10:35
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Trap extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits() {
        return $this->hasMany(Visit::class);
    }
}
