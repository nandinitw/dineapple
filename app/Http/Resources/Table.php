<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Table extends ResourceCollection
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
            'outlet_id' => $this->outlet_id,
            'table_name' => $this->table_name,
            'outlet_slug' => $this->outlet_slug,
            'no_of_persons' => $this->no_of_persons,
            'status' => $this->status,
            'state' => $this->state,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by
            
        ];    
    }

    public function with($request)
    {
        return ['status' => '200'];
    }
}
