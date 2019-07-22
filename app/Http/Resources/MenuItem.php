<?php

namespace App\Http\Resources;
use App\Models\ItemVariant;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItem extends JsonResource
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
            'group_id' => $this->group_id,
            'name' => $this->name,
            'ingredients' => $this->ingredients,
            'preparation_time' => $this->preparation_time,
            'min_order' => $this->min_order,
            'description' => $this->description,
            'special_notes' => $this->special_notes,
            'state' => $this->state,
        ];    
    }

    public function with($request)
    {
        return [
            'bseurl'=> asset('storage/media/'),  
            'status' => '200'
        ];
    }
}
