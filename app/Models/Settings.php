<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = array("hotel_id","outlet_id","device_id","setting_name","setting_value");
}
