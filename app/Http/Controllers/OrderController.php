<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Cart;
use DB;
use Auth;

class OrderController extends Controller
{

    public function __construct(Order $order, OrderItems $orderItem)
    {
        $this->order = $order;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_txt = $request->search_txt;
        $orders = $this->order->getAllOrders($request);
        return view('admin.orders.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id){
            $orderdetails = DB::table('orders')
            ->join('carts', 'carts.order_id', '=', 'orders.order_id')
            ->join('menu_items', 'menu_items.id', '=', 'carts.item_id')
            ->where('orders.order_id','=',$id)
            ->select('carts.*','menu_items.name as title','menu_items.image', 'orders.id','orders.updated_at')
            ->get();

           $user = DB::table('users')
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->where('orders.order_id','=',$id)
            ->select('users.*')
            ->first();
        }

        return view('admin.orders.details',compact('id','orderdetails','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->order->find($id);
        $availableStatus = $this->getStatusOptions($order->status);
        $class = $this->order->getStatusClass($order->status);
        return view('admin.orders.details',compact('order','availableStatus','class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filter(Request $request){


        $query = DB::table('carts')
                    ->join('users', 'users.id', '=', 'carts.user_id')
                    ->join('menu_items', 'menu_items.id', '=', 'carts.item_id')
                    ->orderBy('carts.created_at')
                    ->select('users.name as user','users.id as user_id', 'menu_items.name as itemname','menu_items.id as item_id','menu_items.image', 'menu_items.price_unit as unit' ,'carts.item_price','carts.created_at','carts.purchased_date','carts.order_id as order_id');

                    if( $request->filter_user !="" ){
                         $query->where('carts.user_id', '=', $request->filter_user);
                    }
                    if( $request->filter_item !="" ){
                         $query->where('carts.item_id', '=', $request->filter_item);
                    }

        $cartItems = $query->paginate(10);


        $items =  DB::table('menu_items')
                ->distinct()
                ->join('carts','carts.item_id','=','menu_items.id')
              //  ->whereNotNull('carts.purchased_date')
                ->select('menu_items.name as name','menu_items.id as id')
                ->orderBy('name')
                ->get();

        $users = DB::table('users')
                ->distinct()
                ->join('orders','orders.user_id','=','users.id')
                ->select('users.name','users.id')
                ->orderBy('users.name')
                ->get();

        return view('admin.orders.filter',compact('items','users','cartItems'));
    }

    public function updateStatus(Request $request)
    {
        $order_id = $request->get('order_id');
        $status = $request->get('status');
        $user_id = Auth::user()->id;
        $result = $this->order->updateStatus($order_id,$status,$user_id);
        return redirect('orders')->with('success', 'Order Updated Successfully');
    }

    private function getStatusOptions($status)
    {
        $statusOptions = [];
        switch($status){
            case "ORDERED" :
                $statusOptions = ['SERVED','COMPLETED','CANCELLED'];
                break;
            case "SERVED" : 
                $statusOptions = ['SERVED','ORDERED','COMPLETED'];
                break;    
            case "COMPLETED" :
                $statusOptions = ['COMPLETED'];
                break;
            case "CANCELLED" : 
                $statusOptions = ['CANCELLED'];
                break;        
        }
        return $statusOptions;
    }

    public function trash($id)
    {
        $this->order->updateState($id,'-2');
        return redirect('orders')->with('success', 'Order Deleted Successfully');
    }

}
