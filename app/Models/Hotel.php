<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Hotel extends Model
{
    
    public function tables()
    {
        return $this->hasMany('App\Repositories\Tables\Table');
    }

    public function outlets()
    {
        return $this->hasMany('App\Outlet');
    }
    
    public static function getAllHotels(Request $request = null)
    {
        $search_txt = isset($request->search_txt) ?  $request->search_txt : "";
        $filter_state = isset($request->filter_state) ? $request->filter_state : ""; 
        $query = DB::table('hotels');
        
        if($search_txt != "")
        $query->where('name','LIKE','%'.$search_txt.'%');

        if($filter_state!= "")
        $query->where('state','=',$filter_state);
        else
        $query->where('state','>=','0');

        $result = $query->paginate(20);     
        
       return $result;
    }

    public static function getHotelsList(){
 
        $hotels = DB::table('hotels')
        ->join('outlets','hotels.id','=','outlets.hotel_id')
        ->select('hotels.id','hotels.name')
        ->groupby('hotels.id')
        ->get();

        return $hotels;
    }

    public function getHotelsCount()
    {
        return $this->where('state', '>','-2')->count();
    }

    public function getRecentHotels()
    {
        return $this->where('state', '>','-2')
                    ->orderby('updated_at','DESC')
                    ->take(5)
                    ->get();
    }

}
