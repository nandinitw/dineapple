<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //

    public function attributes()
    {
        return $this->hasMany('App\Models\Attribute')->where('state','1');
    }

    public function getActiveSections()
    {
        return $this->where('state','1')->get();
    }
}
