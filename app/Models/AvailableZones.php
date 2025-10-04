<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableZones extends Model
{
    public function setZONESAttribute($value)
    {
        $this->attributes['zones'] = serialize($value);
    }

    public function getZONESAttribute($value)
    {
        return unserialize($value);
    }
}
