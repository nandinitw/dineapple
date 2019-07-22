<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Offer extends Model
{
   public static function getAllItems(Request $request){

        $search_txt = $request->search_txt;
        $filter_state = $request->filter_state; 
        $query = DB::table('offers');
        
        if($search_txt)
        $query->where('offer_name','LIKE','%'.$search_txt.'%');

        if(isset($filter_state))
        $query->where('state','=',$filter_state);
        else
        $query->where('state','>=','0');

        $result = $query->paginate(20);     
        
       return $result;
   }

}
