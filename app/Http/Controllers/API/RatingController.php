<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Ratings;
use App\Models\RatingAnswer;
use DB;
use Auth;
use App\Http\Resources\RatingsCollection;

class RatingController extends BaseController
{
    //
    function __construct(Ratings $rating,RatingAnswer $rating_answer)
    {
        $this->rating = $rating;
        $this->rating_answer = $rating_answer;
    }

    //rate experience ratings list
    public function ratings(Request $request)
    {
        
       if(getOutletID()){
            if(!getUserFromApiToken()){
                return $this->sendError('Unauthenticated'); 
            }
            $user = getUserFromApiToken(); 
            $ratings = Ratings::getCustomerRatingsOfOutlet(getOutletID(),$user); 
          
            $data['user'] = $user;
            $data['ratings'] = $ratings;
            
            return $this->sendResponse($data, 'Ratings Fetched Successfully');      
       }
       return $this->sendError('Invalid Request! No data Available');
    }

    //customer rates experience
    public function rate_experience(Request $request)
    {
        
        if(getOutletID()){
            if(!getUserFromApiToken()){
                return $this->sendError('Unauthenticated'); 
            }
            $user_rating = $this->rating_answer->rateExperience($request,getOutletID());
            return $this->sendResponse($user_rating, 'Thank you for your feedback');      
         }
        return $this->sendError('Invalid Request! No data Available'); 
    }


    //waiters feedback options
    public function waiter_ratings(Request $request)
    {
        if(getOutletID()){
            if(!getUserFromApiToken()){
                return $this->sendError('Unauthenticated'); 
            }
            $waiter_ratings = Ratings::getWaiterRatingsOfOutlet(getOutletID());
            $waiter_ratings = $waiter_ratings->toArray();        
            return $this->sendResponse($waiter_ratings, 'Waiter Ratings Fetched Successfully');      
         }
         return $this->sendError('Invalid Request! No data Available');
    }

    //rate customer by waiter
    public function rate_customer(Request $request)
    {
        $user_id = $request->get('user_id');
        if(getOutletID()){
            if(!getUserFromApiToken()){
                return $this->sendError('Unauthenticated'); 
            }       
            $waiter_rating = $this->rating_answer->rateCustomer($request,getOutletID(),$user_id);
            return $this->sendResponse($waiter_rating, 'Thank you for your feedback');      
        }
        return $this->sendError('Invalid Request! No data Available'); 
    }

}
