<?php

namespace App\Models;
use App\Models\Outlet;
use App\Models\Ratings;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class RatingAnswer extends Model
{
    protected $table = 'ratings_answers';
    protected $fillable = ['outlet_id','rating_id','user_id','rated_by','answer','state'];

    public function ratings()
    {
        return $this->belongsTo('App\Models\Ratings','rating_id');
    }

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

    public function getCustomerRatingAnswers($user_id)
    {
        return $this->where('ratings_answers.state','1')
                    ->join('ratings','ratings.id','=','ratings_answers.rating_id')
                    ->where('ratings_answers.rated_by',$user_id)
                    ->where('ratings.rated_by',"customer")
                    ->groupby('ratings_answers.rating_id')
                    ->orderby('ratings_answers.updated_at','DESC')
                    ->get();
    }

    public static function getRatingAnswers($user_id)
    {  
        $result =  self::where('ratings_answers.user_id',$user_id)
                    ->where('ratings.rated_by','waiter')
                    ->where('ratings_answers.state','1')
                    ->select('ratings_answers.*','ratings.name')
                    ->leftJoin('ratings','ratings.id','=','ratings_answers.rating_id')   
                    ->get();
                    
        return $result;            
    }
    
}
