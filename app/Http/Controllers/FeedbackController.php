<?php

namespace App\Http\Controllers;
use App\Models\Ratings;
use App\Models\RatingAnswer;
use App\Models\RatingsOutlets;
use App\Models\User;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    
    function __construct(User $user,RatingAnswer $rating_answer,RatingsOutlets $rating_outlet){
        $this->user = $user;
        $this->rating_outlet = $rating_outlet;
        $this->rating_answer = $rating_answer;
    }
    public function getCustomerFeedback(Request $request)
    {
        //dd(123);
        $users = $this->user->getCustomers($request);
        return view('admin.feedbacks.index', compact('users'));
    }

    public function viewFeedback($id)
    {
        $ratings = $this->rating_answer->getCustomerRatingAnswers($id);
        $user = $this->user->find($id);
        return view('admin.feedbacks.view', compact('ratings','id','user'));
    }

   
    


}
