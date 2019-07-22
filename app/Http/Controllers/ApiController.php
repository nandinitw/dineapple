<?php

namespace App\Http\Controllers;

 

use Illuminate\Routing\UrlGenerator;

use Illuminate\Http\Request;
use App\Models\Menugroup;
use App\Models\MenuItem;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use DB;

 

class ApiController extends Controller
{
    
    public function menulist(Request $request){

         if($request->api_token && $request->user_id &&  $this->validateUser($request->api_token,$request->user_id) ){  
            $menugroups = Menugroup::where('status', 'Y')->get();
            $response['data'] = $menugroups;
            if( sizeof($menugroups))
                $response['code'] = 200;            
            else
                $response['code'] = 202;      
         }else{
            $response['code'] = 400;
         }
         $response['imagebase'] = env('APP_URL').'/storage/app/public/media/';
         return response()->json($response);
    }
       
    public function itemlist(Request $request){        
         if($request->api_token && $request->group_id && $this->validateUser($request->api_token,$request->user_id)  ){            
            $menuitems = MenuItem::where('status', 'Y')
                                ->where('group_id', $request->group_id)
                                ->get();     
            $response['data'] = $menuitems;
            if( sizeof($menuitems))             
                $response['code'] = 200;
            else
                $response['code'] = 202;
         }else{
            $response['code'] = 400;
         }
         $response['imagebase'] = env('APP_URL').'/storage/app/public/media/';
         return response()->json($response);
    }
    
                    
     public function addtocart(Request $request){        
         $response=array();
         $itemsarray = $request->items;
         
         if($request->api_token && $request->user_id && $itemsarray &&  $this->validateUser($request->api_token,$request->user_id) ){
                $order_id = $this->getOrderID();                
                $order = new Order;
                $order->order_ID = $order_id;
                $order->user_id = $request->user_id;
                $order->notes = $request->notes; 
                $order->status = "Pending";
                
                if( $order->save()){                    
                    foreach($itemsarray as $key => $item){
                        $itemsarray[$key]['order_id'] = $order_id;
                        $itemsarray[$key]['updated_at'] = date('Y-m-d');
                    }                   
                    Cart::insert($itemsarray);
                    $response['order_id'] = $order_id;
                    $response['code'] = 200;
                }else{
                    $response['code'] = 202;
                }
         }else{
                    $response['code'] = 400;
         }         
         return response()->json($response);
    }
    
    
    public function getOrderID(){                
        $records = count( Order::all() );        
        if( $records ==0 )
            return 1000000001;
        elseif( $records > 0){
            $record = Order::max('order_ID');
            return $record+1;
        }
    }
    
    
    public function validateUser($token, $userid){        
       
       $user = User::where('api_token', $token)
          ->where('id',$userid)
          ->get();
       
        if( sizeof($user) > 0){
            return true;
        }else if( sizeof($user) == 0){
          $response['code'] = 400;
          return false;
        }
    }

    
}
