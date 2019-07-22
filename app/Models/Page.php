<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Page extends Model
{
  
    public static function getAllPages(Request $request){
        //this->request->get('search_txt')
        $search_txt = $request->search_txt;
        $filter_state = $request->filter_state; 
        $query = DB::table('pages');
        
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
