<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use App\Models\MenuItem;
use App\Models\Menugroup;
use App\Models\Cart;
use Auth;
use DB;

class FrontendController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function listitems(Request $request){
        $menugroups = Menugroup::paginate(20);        
        //fetch items from cart
        
        $cartItems = Cart::getCartItems();
        return view('frontend.menugroups.index', compact('menugroups','cartItems'));
    }
    
    public function itemlist(Request $request){
        
        if($request->id){
           $menuitems = MenuItem::where('status', 'Y')
                   ->where('group_id', $request->id)
                   ->paginate(20);
        }
       
        $cartItems = Cart::getCartItems();        
        $purchase_list = $cartItems->toArray();
        if( sizeof($purchase_list)){
           $purchase_list = array_column($purchase_list, 'id'); 
        }
        
        return view('frontend.menugroups.items', compact('menuitems','cartItems','purchase_list'));
    }
}
