<?php

namespace App\Models;
use App\Models\Outlet;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Ratings;
use Auth;

class RatingAnswer extends Model
{
    protected $table = 'ratings_answers';
    protected $fillable = ['outlet_id','rating_id','user_id','rated_by','answer','state'];
   
    public  function rateExperience($request,$outlet_id)
    {
       $params = $request->all();      
       $ratings = $params['ratings'];
       $user = $params['user'];
       if($user){
           $loggedInuser = User::find(getUserFromApiToken()->id);
           $loggedInuser->name = $user['name'];
           $loggedInuser->city = $user['city'];
           $loggedInuser->email = $user['email'];
           $loggedInuser->nationality = $user['nationality'];
           $loggedInuser->mobile = $user['mobile'];
           $loggedInuser->touch();
           $loggedInuser->save();
       }
       if($ratings){
           foreach($ratings as $key => $feedback)
           {
               $rating = Ratings::findBySlug($key);
               $rating_id = $rating->id;
               $result = $this->create(
                    [
                        'outlet_id'  => $outlet_id,
                        'rating_id'  => $rating_id,
                        'rated_by'   => $loggedInuser->id,
                        'answer'     => $feedback,
                        'state'      => '1'
                    ]
                );
                $result->touch();
                $result->save();
           }
       }
       
       return true;
    }

    public  function rateCustomer($request,$outlet_id,$user_id)
    {
        $params = $request->all();
        $ratings = $params['waiter_ratings'];
        $loggedInUser = getUserFromApiToken();
        if($ratings){
           foreach($ratings as $key => $feedback)
           {
               $rating = Ratings::findBySlug($key,'WAITER');
               $rating_id = $rating->id;
               $result = $this->create(
                    [
                        'outlet_id'  => $outlet_id,
                        'rating_id'  => $rating_id,
                        'rated_by'   => $loggedInUser->id,
                        'user_id'    => $user_id,
                        'answer'     => $feedback,
                        'state'      => '1'
                    ]
                );
                $result->touch();
                $result->save();
           }
       }
       return true;
    }
    
}
