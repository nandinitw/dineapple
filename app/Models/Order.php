<?php

namespace App\Models;
use App\Models\OrderItems;
use App\Models\ItemVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function instock(){
        return true;
    }

    public function items()
    {
        return $this->hasMany('App\Models\OrderItems');
    }

    public function table()
    {
        return $this->belongsTo('App\Repositories\Tables\Table');
    }

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlet');
    }

    public function order( $items, $order_id ){
      
        if( sizeof($items ) )
        {
            foreach( $items as $item ){              
                $order_item = new OrderItems();
                //$variant = ItemVariant::find($item['item_variant_id']);//if needed to fetch price from variants table
                $order_item->order_id = $order_id; 
                $order_item->item_id = $item['item_id'];
                //$order_item->item_variant_id = $item['item_variant_id'];
                $order_item->price = $item['price'];
                $order_item->quantity = $item['quantity'];
                $order_item->offer_id = $item['offer_id'];
                $order_item->discount = $item['discount'];
                $order_item->state = '1';
                $order_item->save();
            }
            return true;
        }
        return false;
    }


    //dine_orders, dine_tables
    public function getOutletOrders($outlet){
        $result = array();
        if($outlet){
            $resultset = DB::table('orders')
                    ->join('tables','tables.id','=','orders.table_id')
                    ->where('tables.outlet_id',$outlet)
                    ->select('orders.*','tables.id as table_id','tables.table_name')
                    ->where('orders.state', '>','-2')
                    ->orderby('tables.id')
                    ->get();
        }
        return $resultset;        
    }

    public function getCustomerOrders($outlet_id,$user){
        $result = array();
        $user_id = $user->id;
        if($outlet_id){
            $resultset = DB::table('orders')
                    ->join('tables','tables.id','=','orders.table_id')
                    ->join('users','users.id','=','orders.user_id')
                    ->join('order_items','users.id','=','orders.user_id')
                    ->where('tables.outlet_id',$outlet_id)
                    ->where('orders.user_id',$user_id)
                    ->where('orders.state', '>','-2')
                    ->select('orders.*','tables.id as table_id','tables.table_name','users.email as user_email')
                    ->groupby('orders.id')
                    ->orderby('orders.updated_at', 'DESC')
                    ->get();
            return $resultset;                
        }
        return false;
    }

    public function updateStatus($order_id,$status,$user_id)
    {
        $order = $this->find($order_id);
        if($order){
            $order->status = $status;
            $order->updated_by = $user_id;
            $order->touch();
            $order->save();
            return true;
        }
        return false;
    }

    public function getAllOrders($request)
    {
       
        $search_text = $request->search_txt;
        $outlet_id = $request->outlet;
        $filter_state = $request->filter_state;
        $query = $this->join('users','users.id','=','orders.user_id')
                      ->join('tables','tables.id','=','orders.table_id')
                      ->select('orders.*','users.email') ; 
        if($search_text != ""){
            $query->where('users.email','LIKE','%'.$search_text.'%')
                  ->orwhere('users.name','LIKE','%'.$search_text.'%')
                  ->orwhere('orders.id','LIKE','%'.$search_text.'%')
                  ->orwhere('orders.transaction_id','LIKE','%'.$search_text.'%')
                  ->orwhere('orders.status','LIKE','%'.strtoupper($search_text).'%');

        }
        if($filter_state != ""){
            $query->where('orders.state',$filter_state);

        }
        if($outlet_id != ""){
            $query->where('tables.outlet_id',$outlet_id);

        }
        return $query 
                ->where('orders.state', '>','-2')
                ->orderby('orders.updated_at', 'DESC')
                ->paginate(50);
    }

    public function updateState($order_id,$state)
    {
        return $this->where('id', $order_id)
        ->update(['state' => $state]);
    }

    public function getOrdersCount()
    {
        return $this->where('state', '>','-2')
                    //->whereIn('status',[''])
                    ->count();
    }

    public function getRecentOrders()
    {
        return $this->where('state', '>','-2')
                    ->orderby('updated_at','DESC')
                    ->take(5)
                    ->get();
    }

    public function getStatusClass($status)
    {
        $class = "";
        switch($status){
          case "SERVED" : 
                $class = "btn-warning";
                break;
          case "ORDERED" : 
                $class = "btn-primary";
                break;  
          case "COMPLETED" : 
                $class = "btn-success";
                break;            
        }

        return $class;
    }

}
