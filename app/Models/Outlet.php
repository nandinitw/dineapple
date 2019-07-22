<?php

namespace App\Models;
use DB;
use App\Models\Ratings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Outlet extends Model
{
    protected $fillable = ['name','outlet_slug','hotel_id','created_user_id','updated_user_id','state'];
    
    public static function getAllOutlets(Request $request = null)
    {

        $search_txt = isset($request->search_txt) ?  $request->search_txt : "";
        $filter_state = isset($request->filter_state) ? $request->filter_state : ""; 
        $hotel_id = $request->has('hotel_id') ?  $request->get('hotel_id') : "";
        $query = DB::table('outlets');
        $outlet_id = $request->has('outlet') ? $request->get('outlet') : "";
        
        if($outlet_id != ""){
            $query->where('id','=',$outlet_id);
        }

        if($search_txt != "")
        $query->where('name','LIKE','%'.$search_txt.'%');

        if($hotel_id != ""){
            $query->where('hotel_id','=',$hotel_id);
        }

        if($filter_state!= "")
        $query->where('state','=',$filter_state);
        else
        $query->where('state','>=','0');

        $result = $query->paginate(20);     
        
       return $result;

    }

    public static function getUserOutlets($outlet_id){
        $query = DB::table('outlets');
        $query->where('state','>=','0');
        $query->where('id',$outlet_id);
        $result = $query->paginate(20);    
        return $result;
    }

    public static function getOutlets($hotel_id = null)
    {

        $result = [];
        if($hotel_id){
            $result = DB::table('outlets')
                        ->where('hotel_id',$hotel_id)
                        ->where('state','1')
                        ->get(); 
            }
        return $result;
    }

    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotel');
    }

    public function tables()
    {
        return $this->hasMany('App\Models\Hotel');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function ratings()
    {
        return $this->belongsToMany(Ratings::class, 'ratings_outlets');
    }
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function getOutletsCount()
    {
        return $this->where('state', '>','-2')->count();
    }

    public function getRecentOutlets()
    {
        return $this->where('state', '>','-2')
                    ->orderby('updated_at','DESC')
                    ->take(5)
                    ->get();
    }

}
