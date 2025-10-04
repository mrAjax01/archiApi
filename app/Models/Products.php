<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;

    public function setVALAttribute($value)
    {
        $this->attributes['val'] = serialize($value);
    }

    public function getVALAttribute($value)
    {
        return unserialize($value);
    }
}
