<?php

namespace App\Models;
use App\Models\Outlet;
use App\Models\RatingAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Ratings extends Model
{

    public static function getAllItems(Request $request){

        $search_txt = $request->search_txt;
        $filter_state = $request->filter_state; 
        $query = DB::table('ratings');
        
        if($search_txt)
        $query->where('name','LIKE','%'.$search_txt.'%');

        if(isset($filter_state))
        $query->where('state','=',$filter_state);
        else
        $query->where('state','>=','0');

        $result = $query->paginate(20);     
        
       return $result;
   }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function outlets()
    {
        return $this->belongsToMany(Outlet::class, 'ratings_outlets','rating_id');
    }


    public function rating_answer()
    {
        return $this->hasMany('App\Models\RatingAnswer');
    }

    public static function getCustomerRatingsOfOutlet($outlet_id)
    {
        $results =  DB::table('ratings')
                    ->join('ratings_outlets', 'ratings_outlets.rating_id', '=', 'ratings.id')
                    ->where('outlet_id',$outlet_id)
                    ->where('ratings.state','1')
                    ->where('rated_by','CUSTOMER')
                    ->get();       
        return $results;
    }

    public static function findBySlug($slug,$rated_by='CUSTOMER')
    {
        return self::where('slug',$slug)
                    ->where('rated_by',$rated_by)    
                    ->first();

    }

    public static function getWaiterRatingsOfOutlet($outlet_id)
    {
        $results =  DB::table('ratings')
                    ->join('ratings_outlets', 'ratings_outlets.rating_id', '=', 'ratings.id')
                    ->where('outlet_id',$outlet_id)
                    ->where('ratings.state','1')
                    ->where('rated_by','WAITER')
                    ->get();    
        return $results;            
    }

   
    
}
