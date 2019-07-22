<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use App\Models\MenuItem;

class MenuGroup extends Model
{

     protected $fillable = ['name','description','price'];


     public function menu_items()
     {
          return $this->hasMany('App\Models\MenuItem');
     }

     public static function getAllItems(Request $request){

          $search_txt = $request->search_txt;
          $filter_state = $request->filter_state; 
          $outlet_id = $request->outlet;
          $query = DB::table('menu_groups');

          if($outlet_id != ""){
               $query->where('outlet_id',$outlet_id);
   
           }
          
          if($search_txt)
          $query->where('name','LIKE','%'.$search_txt.'%');
  
          if(isset($filter_state))
          $query->where('state','=',$filter_state);
          else
          $query->where('state','>=','0');
  
          $result = $query->paginate(20);     
          
         return $result;
     }

     public function getActiveMenuGroups($outlet_id)
     {
          return DB::table('menu_groups')
                           ->where('state','=','1')
                           ->where('outlet_id','=',$outlet_id)
                           ->get();     
     }

}
