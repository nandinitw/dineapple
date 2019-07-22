<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Cart extends Model
{
    //
    protected $table = 'cart_items';
    
    protected $fillable = ['item_id','price','quantity'];
    
    public static function getCartItems(){
        
          $cartItems = DB::table('carts')
               ->join('menu_items', 'menu_items.id', '=', 'carts.item_id')
               ->where('carts.user_id','=', Auth::getUser()->id)               
               ->whereNull('carts.order_id')
               ->orderBy('carts.created_at')
               ->select('menu_items.*', 'carts.id as cart_id','carts.item_price as item_price')
               ->get();
                             
               return $cartItems;   
    }
}
