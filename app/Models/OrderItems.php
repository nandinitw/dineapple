<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MenuItem;

class OrderItems extends Model
{
    protected $fillable = ['order_id','item_id','price','quantity','offer_id','discount','state'];

    public function order()
    {        
        return $this->belongsTo('App\Models\Order');
    }

    public function getOrderDetails($order_id)
    {
        $result =  $this->where('order_id',$order_id)
                        ->get();
        return $result;
    }

    public function item()
    {
        return $this->belongsTo('App\Models\MenuItem','item_id','id');
    }


}


