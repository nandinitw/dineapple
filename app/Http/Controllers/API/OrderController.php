<?php

namespace App\Http\Controllers\API;

 
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller; 
use App\Http\Resources\OrderItem as OrderItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Validator;

class OrderController extends BaseController
{

    function __construct(Order $order, OrderItems $order_item)
    {
        $this->order = $order;
        $this->order_item = $order_item;
    }
    
    private function CreateOrder($request){
            $user = getUserFromApiToken();       
            $order = new Order();
            $order->transaction_id = rand();
            $order->user_id = $user->id;
            //$order->updated_by = $user->id;
            $order->table_id = $request->table_id;
            $order->status = "ORDERED";
            $order->state = '1';
            $order->save();

            return $order->id;
    }

    public function instockorder(Request $request){      

            $order_id = $this->CreateOrder($request);        
            $instock = $this->order->instock($request);
            if($instock){                
                $status = $this->order->order($request->get('items'),$order_id); 
                if($status){
                    $data['order_id'] = $order_id;                    
                    return $this->sendResponse($data, 'Successfully completed order!'); 
                }
            }
            return $this->sendError('Invalid Request! No data Available');
    }

    public function getOrders(){

        if( $outlet_id = getOutletID() ){
            $result = $this->order->getOutletOrders($outlet_id);
            if( sizeof($result) ){
                return $this->sendResponse($result,'Order list'); 
            }
            return $this->sendError('Invalid Outlet!');
        }
        return $this->sendError('Invalid Request!');
    }

    public function getCustomerOrders(){
        $outlet_id = getOutletID();
        $user   = getUserFromApiToken();
        if($outlet_id){
            if($user){
                $result = $this->order->getCustomerOrders($outlet_id,$user);
                if( sizeof($result) ){
                    return $this->sendResponse($result,'Customers orders'); 
                }
            }
            return $this->sendError('User does not exist!!');
        }
        
        return $this->sendError('Invalid Request!');

    }

    public function getOrderDetails(Request $request){
        $order_id = $request->get('order_id');
        $orders = $this->order_item->getOrderDetails($order_id);
        $result =  OrderItemResource::collection($orders);
        if( sizeof($result) ){
            return $this->sendResponseWithBaseURL($result,'Order details'); 
        }
        return $this->sendError('Invalid Order ID! No data available');

    }

    public function updateOrderStatus(Request $request){
        $outlet_id = getOutletID();
        $user   = getUserFromApiToken();
        if($user){
            $order_id = $request->get('order_id');
            $status = $request->get('status');
            if($order_id && $status){
                $result = $this->order->updateStatus($order_id,$status,$user->id);
                if($result){
                    return $this->sendResponse($result,'Order updated successfully');      
                }
                return $this->sendError('Order ID does not exist!');
            }
            return $this->sendError('Invalid Parameters!');
        }
        return $this->sendError('Invalid Request!');
    }   




    


}
