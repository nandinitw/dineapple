<?php

namespace App\Http\Controllers\API;

use App\Models\Hotel;
use App\Models\Outlet;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;

class SettingsController extends BaseController
{
     
    public function index(Request $request = null)
    { 
       if( $results = Hotel::getAllHotels() ){ 
        $message = "Select a hotel";        
        $results = $results->toArray();
      
        return $this->sendResponse($results, $message);  
       }
       return $this->sendError('Invalid Request! No data Available');
    }

    public function getOutlets(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "hotel_id" => "required|numeric"        
        ]);       

        if( $validator->fails() ){
            return $this->sendError('Few arguments passed');
        }        
       if( $results = Outlet::getOutlets($request->get('hotel_id')) ){
            $message = "Select an outlet";
            return $this->sendResponse($results, $message);  
       }
       return $this->sendError('Invalid Request! No data Available');
    }

    public function registerApp(Request $request){

        $validator = Validator::make($request->all(),[
            "hotel_id" => "required",
            "outlet_id" => "required",
            "setting_name" => "required",
            "setting_value" => "required",
        ]);

        if( $validator->fails()){
            return $this->sendError('Few arguments passed!');
        }

        $data = array(
            "hotel_id"=>$request->get('hotel_id'),
            "outlet_id"=>$request->get('outlet_id'),
            "setting_name"=>$request->get('setting_name'),
            "setting_value"=>$request->get('setting_value'),
        );
        
        $model = Settings::where('hotel_id', '=', $request->get('hotel_id'))
                ->where('outlet_id', '=', $request->get('outlet_id'))
                ->where('setting_name', '=', $request->get('setting_name'))
                ->where('setting_value', '=', $request->get('setting_value'))->first();

        if(!$model){
            $register = Settings::create($data);
            if( $register->save() ){

                $client_secret = DB::table('oauth_clients')
                ->where('oauth_clients.outlet_id',$request->get('outlet_id'))
                ->select('oauth_clients.id', 'oauth_clients.secret')
                ->get();
 
                if( sizeof($client_secret) ){
                    $client_secret = $client_secret->toArray();
                    $register['client_id'] = $client_secret[0]->id;
                    $register['client_secret'] = $client_secret[0]->secret;
                }else{
                    return $this->sendError("Outlet not yet created");        
                }

                $message = "Settings sucessfully saved";
                return $this->sendResponse($register, $message);
            }
        }else{
            return $this->sendError("Settings already saved!");
        }

    }
    
    public function fetchAppSettings(Request $request){

        if(getOutletID()){
            $outlet_id = getOutletID();
            $settings = Settings::where('outlet_id', '=', $outlet_id)->get(); 
            if($settings){
                $message = "Saved settings!";
                return $this->sendResponse($settings, $message);
            }else{
                $message = "Settings not found!";
                return $this->sendResponse($settings, $message);
            }    
        }
        return $this->sendError('Invalid Request! No data Available');  
    }


}
