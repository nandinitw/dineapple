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

    
    public function updateVariants($request)
    {
        if(sizeof($request['variants'])){
            $item_variant = $this->where('item_id',$request->id)->first();
            $item_variant['attributes'] = json_encode($request['variants'][0]);
            $item_variant['price'] = (double)$request['variants'][0]['price'];
            $item_variant->touch();
            $item_variant->save();
            return true;
         }   
    }

}
