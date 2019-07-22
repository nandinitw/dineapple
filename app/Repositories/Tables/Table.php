<?php

namespace App\Repositories\Tables;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = "tables";

    protected $fillable = [
        'table_name',
        'outlet_id',
        'no_of_persons',
        'state',
        'status'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotel');
    }

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlet');
    }

    public static function getTablesByOutletID($outlet_id)
    {
        return self::where('outlet_id',$outlet_id)->where('state','1')->get();
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Orders');
    }
}
