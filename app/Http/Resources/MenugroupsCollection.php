<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MenugroupsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'success' => 'true',
            'data' => $this->collection,
            'bseurl'=> asset('storage/media/'),  
            'status'  => '200' 
        ];
    }
}
