<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MenuItem as MenuItemResource;
use App\Models\MenuItem;

class OrderItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    { 
        return [
            'id'       => $this->id,
            'order_id' => $this->order_id,
            'item_id'  => $this->item_id,
            'item_variant_id'  => $this->item_variant_id,
            'price'    => $this->price,
            'quantity' => $this->quantity,
            'offer_id' => $this->offer_id,
            'discount' => $this->discount,
            'details'  => MenuItem::getMenuItemDetails($this->item_id,$this->item_variant_id) , 
        ];    
    }

    public function with($request)
    {
        return [
            'bseurl'=> asset('storage/app/public/media/'),  
            'status' => '200'
        ];
    }
}
