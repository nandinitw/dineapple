<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MenuItem;

class ItemVariant extends Model
{
    //
    protected $fillable = ['item_id','attributes','sku','mrp','price','inventory','media'];

    public function item(){
        return $this->belongsTo('App\Models\MenuItem');
    }

    public static function getVariants($item_id)
    {
        $results = self::where('item_id',$item_id)
                        ->get();
        return $results;                
    }

}
