<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributesOutlets extends Model
{
    //
    protected $table = "attributes_outlets";
    protected $fillable = ['attribute_id','outlet_id ','state'];

    public function assignAttributes($request)
    {
        $res = $this->where('outlet_id', $request->outlet_id)->delete();
        $attribute = array();
        if( sizeof($request->attribute_id) ){
            foreach($request->attribute_id as $item){
                $attribute[] = array(
                    'outlet_id'=> $request->outlet_id,
                    'attribute_id'=> $item,
                    'state'=>'1'
                );
            }
        }         
        $assigned = $this->insert($attribute);
        return true;
    }

    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }

    public function getAttributesForOutlet($outlet_id)
    {
        $assigned =  $this->where('outlet_id',$outlet_id)
                    ->get();
        if( sizeof($assigned->toArray()) ){
                        $assigned = $assigned->toArray();
                        $assigned = array_column($assigned,'attribute_id');
                    }  
        //dd($assigned);            
        return $assigned;                      
    }

}
