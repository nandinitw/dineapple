<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Table as TableResource;
use App\Repositories\Tables\Table;

class Outlet extends JsonResource
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
            'id'   => $this->id,
            'name' => $this->name,
            'outlet_slug' => $this->outlet_slug,
            'hotel_id' => $this->hotel_id,
            'outlet_image' => $this->outlet_image,
            'state' => $this->state,
            'tables'=> TableResource::collection(Table::getTablesByOutletID($this->id))
            
        ];    
        //return parent::toArray($request);
    }

    public function with($request)
    {
        return ['status' => '200'];
    }
}
