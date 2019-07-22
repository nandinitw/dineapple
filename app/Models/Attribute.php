<?php

namespace App\Models;
use App\Models\Outlet;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Str;

class Attribute extends Model
{
   
    protected $fillable = [
        'name',
        'slug',
        'section_id',
        'values',
        'type',
        'state'
    ];

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }
    
    public function getCustomAttributes($outlet_id,$section)
    { //dd($section);
        return DB::table('attributes')
                    ->join('sections', 'attributes.section_id', '=', 'sections.id')
                    //->where('attributes.outlet_id',$outlet_id)
                    ->where('attributes.state','1')
                    ->where('sections.slug',$section)
                    ->get(['attributes.*']);    
    }

    public function getAssignedAttributes($itemid){

            $varients = DB::table('item_variants')
            ->where('item_id','=',$itemid)            
            ->where('state','1')            
            ->select('item_variants.attributes')
            ->get();

            $varients = ( !empty($varients) )? json_decode($varients) : array();

            return $varients;        
    }

    public function getAllAttributes($search_text = "",$filter_state = "")
    {
        $query = self::where('state', '>','-2');
        if($search_text != ""){
            $query->where('name','LIKE','%'.$search_text.'%');

        }
        if($filter_state != ""){
            $query->where('state',$filter_state);

        }
        return $query->paginate(10);
    }

    public function store($data)
    {
        $result = $this->create(
            [
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'section_id' => $data['section_id'],
                'type' => $data['type'],
                'values' => $data['values'],
                'state' => $data['state'],
            ]
        );
        $result->touch();
        $result->save();

        return $result;
    }

    public function get($attribute_id)
    {
        return $this->find($attribute_id);
    }

    public function updateData($data)
    {
     
        $attribute = $this->find($data['id']);
        $attribute->name = $data['name'];
        $attribute->slug = Str::slug($data['name']);
        $attribute->section_id = $data['section_id'];
        $attribute->type = $data['type'];
        $attribute->values = $data['values'];
        $attribute->state = $data['state'];
        $attribute->touch();
        $attribute->save();

        return $attribute;
    }

    public function updateState($id,$state)
    {
        return $this->where('id', $id)
                           ->update(['state' => $state]);
    } 

    public function batchDelete($attribute_ids)
    {
        return $this->whereIn('id', $attribute_ids)
                    ->update(['state' => '-2']);
    }

  

    
}
