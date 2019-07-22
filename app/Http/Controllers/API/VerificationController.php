<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; 
use DB;
use Validator;


class VerificationController extends BaseController   
{
    
    public function verifyuser(Request $request)
    {           
            $user = array(); 
            $otpKey = mt_rand(1000,9999);

            $validator = Validator::make($request->all(), [
                "email" => "required",                
            ]);
           
            if( $validator->fails() ){
                return $this->sendError('Invalid Request!');
            }

            $email = $request->get('email');

            if( is_numeric($email) ){       

                $user = User::where('mobile', '=', $email )->first();     

            }elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {   

                $user = User::where('email', '=', $email )->first();

            }       

            if( $user ){  

                $user = User::find($user->id);
                $user->otp = $otpKey;
                $user->save();
                //send otp code via email or phone          
                $result['email'] = $request->get('email');
                $result['otp'] = $otpKey;                                
                $message = "Please enter your OTP";  

                return $this->sendResponse($result, $message);
            }else{
                return $this->sendError('Please register to login');
            }
    }


    public function login(Request $request){
                
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "otp" => "required",
        ]);

        if( $validator->fails() ) {  
            return $this->sendError('Invalid Request!'); 
        }

        $email = $mobile = null;
        $otp = $request->get('otp');
        $flag_email = false;

        if( is_numeric($request->get('email') ) ){          
            $mobile = $request->get('email');                              
            $user = User::where('mobile', '=', $mobile )->first();                
        }elseif ( filter_var($request->get('email') , FILTER_VALIDATE_EMAIL) ) {  
            $email = $request->get('email');                 
            $user = User::where('email', '=', $email )->first();    
            $flag_email = true;           
        } 

        if($user){  
            
            $getusers =  DB::table('users')
            ->where('otp', '=', $otp)
            ->when( $email, function ( $getusers, $email ) {
                return $getusers->where('email', $email);
            })
            ->when( $mobile, function ( $getusers, $mobile ) {
                return $getusers->where('mobile', $mobile);
            })            
            ->first();

            if( isset($getusers) ){  
                $loggedInUser = Auth::loginUsingId( $getusers->id, TRUE );                
                $getusers->token =  $user->createToken('MyApp')->accessToken; 
                $message = "Welcome to dineapple";  
                return $this->sendResponse($getusers, $message);     

            }else{

                $message = "OTP Error!";  
                return $this->sendError($message);     
            }    

        }else{
            
            return $this->sendError("Invalid email/mobile!"); 
        }
    }   

    
    public function passwordlogin(Request $request){       
      
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required",
        ]);       

        if( $validator->fails() ) {   
            return $this->sendError('More parameters expected');                         
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $message = "Login successfull";  
            $user = Auth::user();                         
            return $this->sendResponse($user, $message);    
        }  
        $message = "Login error!!";
        return $this->sendError( 'Invalid email/mobile!' );         
    }

    public function register(Request $request){

        //to be changed when dynamic api is passed
        //$outlet_id = getOutletID();

        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "mobile" => "required"        
        ]);

        if( $validator->fails() ){
            return $this->sendError('Invalid request!'); 
        }

        $otpKey = mt_rand(1000,9999);   

        if( filter_var( $request->get('email'), FILTER_VALIDATE_EMAIL ) && is_numeric($request->get('mobile')) ){

                $userObject = array(
                    'name'=> '',
                    'email'=> $request->get('email'),
                    'password'=> '',
                    'mobile'=> $request->get('mobile'),
                    'role'=> '4',
                    'outlet_id'=> $request->get('outlet_id'),      
                    'api_token' => Str::uuid(),                                                     
                    'otp'=> $otpKey             
                );  
 
                //check users
                $getusers = DB::table('users')
                            ->where('outlet_id', '=', $request->get('outlet_id'))
                            ->where(function ($getusers) use ($request) {
                                $getusers->where('email', $request->get('email')  )
                                        ->orWhere('mobile', $request->get('mobile') );
                            })
                            ->get();

                if( sizeof($getusers) ){                                        
                    return $this->sendError('User exists, please login!'); 
                }        

                if( $user = User::create($userObject) ){

                    $user['token'] =  $user->createToken('MyApp')-> accessToken; 
                    $user['mobile'] =  $user->mobile;   

                    $message = "Successfully registered, please login to continue";  
                    return $this->sendResponse($user, $message);                
                    
                }else{   
                    return $this->sendError('Invalid email/mobile!'); 
                }    

        }else{
            return $this->sendError('Invalid email/mobile!'); 
        }
    }


    public function getusers(Request $request){

        if( $outlet_id = getOutletID() ){

                $users = User::where('state','=','1') 
                    ->select('id','email')
                    ->where('outlet_id','=',$outlet_id)
                    ->get();

                $message = ( sizeof($users) )? "Outlet Users" :"Empty Users List";

                return $this->sendResponse($users,$message);

        }
        return $this->sendError('Invalid request'); 
    }

    public function getuserDetails(Request $request){   

        $user = getUserFromApiToken();
        $loggedInUser = Auth::loginUsingId( $user->id, TRUE );  

    }
    
}
