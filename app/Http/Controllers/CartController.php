<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\MenuItem;
use App\Models\Cart;
use App\Models\Order;
use Session;
use Auth;
use DB;

class CartController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.cart.index');
    }

    public function viewcart(Request $request){

        
        $cartItems =  Cart::getCartItems();
          
        return view('frontend.cart.index',compact('cartItems'));
    }

    public function addtocart(Request $request){
        
        $item_id = $request->item; 
         
         if( $request->action == 'insert'){
            //get item details add to cart        
            $item = MenuItem::findOrFail($item_id);         
            $item = $item->toArray();   
            //$cart = new Cart;
            //$cart->user_id  = Auth::getUser()->id;  
            //$cart->item_id  = $item_id;
            //$cart->item_price = $item['price'];
            //$cart->item_quantity  = 1;
            
            $item_array = array(
                                'user_id'=>Auth::getUser()->id,
                                'item_id'=>$item_id,
                                'item_price'=>$item['price'],
                                'item_quantity'=> 1
                        );
            $cart =  DB::table('carts')->insertGetId(
              $item_array
            );
            
            if( $cart )
                 return response()->json(array('success' => true, 'last_insert_id' =>$cart  ), 200);
            else
                return response()->json(array('success' => false), 404);
               
         }elseif($request->action == 'delete'){            
            $item_id = $request->item;                   
            $cart = Cart::find($item_id);
            if( $cart->delete() )
                 return response()->json(array('success' => true), 200);
            else
                 return response()->json(array('success' => false), 404);
         }
    }
    
    public function checkout(Request $request){
        
        $checkout_items = $request['cart'];
        
            $api = new ApiController(); 
            $ordercounter = $api->getOrderID();
        
            if( isset( $checkout_items) && sizeof( $checkout_items) ){
                    $purchased_date = date('Y-m-d H:i:s');
                    
                     $order = new Order;
                    $order->order_ID = $ordercounter;
                    $order->user_id = Auth::getUser()->id;     
                    $order->save();

                    DB::table('carts')
                    ->whereIn('id', $checkout_items)
                    ->update(array('order_id'=>$ordercounter));                   
                 
            }
            return redirect('listcart')->with('success', 'Checkout process completed!');
        }


}
