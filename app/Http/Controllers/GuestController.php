<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Auth;
use DB;

class GuestController extends Controller
{
    
    public function requestAccess(Request $request){
        
        $this->validate($request, [
            'email' => 'required',            
        ]);
         

        $userEmail = User::where('email', $request->get('email'))->first();    
        $optKey = Str::random(6);
        
        //if user exist
        if( $userEmail ){                       
            $update_user_otp = array('otp'=>$optKey );            
            $result = DB::table('users')
                    ->where('email', $request->get('email'))
                    ->update($update_user_otp);
        }else{
            $newUser = array(
               'name'=>'',
               'email'=> $request->get('email'),
               'password'=>'',
               'mobile'=>'',
               'role'=>'3',
               'api_token'=>Str::random(60),             
               'otp'=>$optKey              
            );                    
            $createUser = DB::table('users')
                        ->insert($newUser);
        }
        
        $response['otp'] = $optKey;
        $response['code'] = 200;
        return response()->json($response);        
    }
    
    
    public function login(Request $request){
        
        // Check validation
        $response = array();
        $this->validate($request, [
            'email' => 'required',
            'otp' => 'required'
        ]);

        $user = User::where('email', $request->get('email'))->first();
       
        if($user){            
                if( $request->get('email') == $user->email) {                
                        if ( ($email = $request->get('email')) && ($otp = $request->get('otp')) ){
                            
                            $api_token = DB::table('users')
                                        ->select('api_token','id')
                                        ->where('email',$email)
                                        ->where('otp',$otp)
                                        ->get();
                            
                            if( sizeof($api_token)){                             
                                $response['api_token'] = $api_token[0]->api_token;
                                $response['user_id'] = $api_token[0]->id;
                                $response['code'] = 200;
                            }
                            else{
                                $response['code'] = 400;
                            }
                            
                        }
                }
                
        }else{
             $response['code'] = 400;
        }
        
        return response()->json($response); 
    }

}

