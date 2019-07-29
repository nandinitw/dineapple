<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItems;
use App\Models\Menugroup;
use App\Models\ItemVariant;
use DB;

class MenuItem extends Model
{
     
   protected $fillable = ['name','description','group_id','price','min_order','price_unit','preparation_time'];
   
   public function item(){
        return $this->hasOne('App\Models\OrderItems');
   }

    public function group(){
            return $this->belongsTo('App\Models\Menugroup');
        }

    public function item_variants()
        {
            return $this->hasOne('App\Models\ItemVariant','item_id');
        }
   
   public static function getAllMenuItems(Request $request){

        $search_txt = $request->search_txt;
        $filter_state = $request->filter_state; 
        $outlet_id = $request->outlet;
        $query = DB::table('menu_items')
                ->join('menu_groups','menu_groups.id','=','menu_items.group_id')
                ->select('menu_items.*');
        
        if($search_txt)
        $query->where('menu_items.name','LIKE','%'.$search_txt.'%');

        if($outlet_id !=""){
            $query->where('menu_groups.outlet_id','=', $outlet_id);
        }

        if(isset($filter_state))
        $query->where('menu_items.state','=',$filter_state);
        else
        $query->where('menu_items.state','>=','0');

        $result = $query->paginate(20);     
        return $result;

   }
   
   public static function getIngredients(){
    
        $ingredients = DB::table('menu_items')->where('ingredients','!=','')->pluck('ingredients');        
        if( sizeof($ingredients->toArray())){            
            $all_ingredient =  explode(",", implode(",", $ingredients->toArray()));
            $ingredients =  array_unique($all_ingredient);
            $ingredients = implode(',', $ingredients);
           
        }
        return $ingredients; 
   }

   /*public static function getMenuItems($outlet_id, $group_id){ 

            $results = array();    
            if( $outlet_id && $group_id ){
 
                $results = DB::table('menu_items')
                        ->join('menu_groups','menu_groups.id','=','menu_items.group_id')
                        ->select('menu_items.*')
                        ->where('menu_groups.outlet_id','=', $outlet_id)
                        ->where('menu_items.group_id','=', $group_id)
                        ->where('menu_items.state','=', '1')
                        ->where('menu_groups.state','=', '1')
                        ->get();
                      
                        
                        if( sizeof($results) ){                            
                            foreach( $results as $key => $menu){  
                                $items = DB::table('item_variants')
                                ->join('menu_items','menu_items.id','=','item_variants.item_id')                        
                                ->select('item_variants.*')
                                ->where('item_variants.item_id','=', $menu->id)
                                ->where('menu_items.state','=', '1')                      
                                ->where('item_variants.state','=', '1')   
                                ->first();  
                                $variants = [];
                                if($items){
                                    $variants = [
                                        'id' => $items->id,
                                        'attributes' => json_decode($items->attributes,true),
                                        'price' => $items->price,
                                        'state' => $items->state
                                    ];        
                                }
                    
                                //$items = $items->toArray();
                                $results[$key]->items = $variants;
                            }   
                            //$results = ($results)? $results->toArray(): array();               
                        }
                        
            }
            return $results;
   }*/

   public static function getMenuItems($outlet_id, $group_id){ 

    $results = array();    
    if( $outlet_id && $group_id ){

        $results = DB::table('menu_items')
                ->join('menu_groups','menu_groups.id','=','menu_items.group_id')
                ->select('menu_items.*')
                ->where('menu_groups.outlet_id','=', $outlet_id)
                ->where('menu_items.group_id','=', $group_id)
                ->where('menu_groups.state','=', '1')
                ->where('menu_items.state','=', '1')
                ->get();
              
                
                if( sizeof($results) ){                            
                    foreach( $results as $key => $menu){  
                        $items = DB::table('item_variants')
                        ->join('menu_items','menu_items.id','=','item_variants.item_id')                        
                        ->select('item_variants.*')
                        ->where('item_variants.item_id','=', $menu->id)
                        ->where('menu_items.state','=', '1')                      
                        ->where('item_variants.state','=', '1')   
                        ->get();  
         
                            
                        $items = $items->toArray();
                        $results[$key]->items = $items;
                    }   
                    //$results = ($results)? $results->toArray(): array();               
                }
                
    }
    return $results;
}

   //function to add menu item varients
   public static function addVarients($menuitem, $request):bool{
 
        $varient = array();

        if( sizeof($request['variants']) ){

            foreach($request['variants'] as $key => $item){            

                if( array_key_exists("price",$item) ){
                    $price = $item['price'];
                    //array_pop($item);
                }
                $attributes = json_encode($item);
                $varient[] = array(
                    'item_id'=> $menuitem->id,
                    'attributes'=> $attributes,
                    'price'=>$price,
                    'state'=>'1'
                );               
            }
            $assigned = DB::table('item_variants')->insert($varient);

            return true;
        }   

        return false;     
    }

    // public function getVarients(){

    // }

    public static function getMenuItemDetails($item_id,$item_variant_id)
    {
        $result = DB::table('item_variants')
                    ->join('menu_items','menu_items.id','=','item_variants.item_id')   
                    ->select('menu_items.*','item_variants.attributes','item_variants.price') 
                    ->where('menu_items.id',$item_id)
                    //->where('item_variants.id',$item_variant_id)//to be changed once item variant id is passed from app to create order api
                    ->first();
        

        return $result;

    }

    public function getItemsCount()
    {
        return $this->where('state', '>','-2')->count();
    }

    public function getRecentMenuItems()
    {
        return $this->where('state', '>','-2')
                    ->orderby('updated_at','DESC')
                    ->take(5)
                    ->get();
    }

    public function updateMenuItem($request)
    {
        $menuItems = $this->findOrFail($request->id);                
        $menuItems->name = $request->name;
        $menuItems->group_id = $request->group_id;
        $menuItems->description = $request->description;                
        $menuItems->min_order = $request->min_order;
        $menuItems->special_notes = $request->special_notes;
        $menuItems->ingredients = $request->ingredients;                
        $menuItems->preparation_time = $request->preparation_time;
        $featured_image  = $request->input('image');

        if($featured_image != '' && !file_exists(storage_path('app/public/media').'/'.$featured_image) ){
                    if(copy('temp/'.$featured_image, storage_path('app/public/media').'/'.$featured_image)){
                        unlink ('temp/'.$featured_image);
                    }
                    $menuItems->image = $featured_image;
        }
        $menuItems->touch();
        $menuItems->save();

        return $menuItems;
    }


    
   
 

  
}

