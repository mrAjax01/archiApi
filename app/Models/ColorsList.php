<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColorsList extends Model
{
    use SoftDeletes;

    protected $table = 'colors_list';

    public function setLABCHD65Attribute($value)
    {
        $this->attributes['LABCH_D65'] = serialize($value);
    }

    public function getLABCHD65Attribute($value)
    {
        return unserialize($value);
    }
}
