<?php
namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Routing\Controller;

class VerifyController extends Controller
{
    public function check(){
         
        $email = request('email');     
        $password =  request('password');  
        $response = array();
               
        if (Auth::validate(['email' => $email, 'password' => $password]))
        {
            $user = User::where('email', '=', $email )->first();         
            $response['status'] = "success";
            $response['token'] = $user->api_token;
            $response['code'] = "200OK";
        }else{
            $response['status'] = "Invalid login!";
            $response['token'] = "";
            $response['code'] = "400";
        }        
        return response()->json($response);      
    }
}
