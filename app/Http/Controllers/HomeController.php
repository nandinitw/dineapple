<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Hotel;
use App\Models\Outlet;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, Order $order, Hotel $hotel, MenuItem $menuItem, Outlet $outlet)
    {
        $this->middleware('auth');
        $this->user = $user;
        $this->order = $order;
        $this->hotel = $hotel;
        $this->menuItem = $menuItem;
        $this->outlet = $outlet;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      // $cartItems = Cart::getCartItems(); 
        $usersCount     =  $this->user->getUsersCount();
        $itemsCount     =  $this->menuItem->getItemsCount();
        $ordersCount    =  $this->order->getOrdersCount();
        $hotelsCount    =  $this->hotel->getHotelsCount();
        $outletsCount   =  $this->outlet->getOutletsCount();

        $hotels          =  $this->hotel->getRecentHotels();
        $outlets         =  $this->outlet->getRecentOutlets();
        $users           =  $this->user->getRecentUsers();
        $menuItems       =  $this->menuItem->getRecentMenuItems();
        $orders          =  $this->order->getRecentOrders();
    
       return view('admin.dashboard',compact('usersCount','itemsCount','ordersCount','hotelsCount','outletsCount',
                'hotels','outlets','users','menuItems','orders'));
    }
}
