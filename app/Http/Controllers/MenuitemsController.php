<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MenuItem;
use App\Models\Menugroup;
use App\Models\Attribute;
use App\Models\ItemVariant;


class MenuitemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(
         Attribute $attribute,
         MenuItem $menuItem,
         ItemVariant $item_variant
        )
    {
        $this->attribute = $attribute;
        $this->menuItem = $menuItem;
        $this->item_variant = $item_variant;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $menuitems = Menuitem::getAllMenuItems($request);
        return view('admin.menuitems.index', compact('menuitems'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
         $ingredients = MenuItem::getIngredients();
         $menugroups = Menugroup::all();
         $outlet_id = $request->has('outlet') ? $request->get('outlet') : "";
         if($outlet_id != ""){
            $menugroups =$menugroups->where('outlet_id',$outlet_id); 
         }
        
         $attributes = $this->attribute->getCustomAttributes('333','products');
         $varients = array();
         //dd($attributes);
         return view('admin.menuitems.create',compact('menugroups','ingredients','attributes','varients'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $required_fields = array(
            'name' => 'required|min:5|unique:menu_items,name,'.($request->id ?? null),
            'group_id'=>'required',
            //'price'=>'required|numeric',
            'min_order'=>'numeric',
            // 'variants.price' => 'required'
        );

        if( !$request->image)
        $required_fields['featured'] = 'required';                

        $validatedData = $request->validate($required_fields);

        if(!$validatedData){
            $error = $v->errors();
            return redirect()->back()->withInput()->withErrors($v->errors());
        }  

        $menuItems = new MenuItem;                
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

        if( $menuItems->save() ){

            if( MenuItem::addVarients($menuItems,$request) ){                        
                $message = "Menu Item successfuly saved";
            }else{                        
                $message = "Menu Item saved, please add varient to the list!";
            }

            return redirect('/menuitems')->with('success',$message );

        }else{
            $message = "Menu item already exist";

            return redirect('/menuitems')->with('error',$message );
        }            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $ingredients = MenuItem::getIngredients();
        $menuitem = MenuItem::findOrFail($id);
        $menugroups = Menugroup::all();
        $outlet_id = $request->has('outlet') ? $request->get('outlet') : "";
        if($outlet_id != ""){
           $menugroups =$menugroups->where('outlet_id',$outlet_id); 
        }
        $attributes = $this->attribute->getCustomAttributes('333','products');            
        $varients = $this->attribute->getAssignedAttributes($id);     

        return view('admin.menuitems.edit',compact('menuitem','menugroups','ingredients','attributes','varients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {         
    
        
        $required_fields = array(
            'name' => 'required|min:5|unique:menu_items,name,'.($request->id ?? null),
            'group_id'=>'required',
            //'price'=>'required|numeric',
            'min_order'=>'numeric',
            // 'variants.price' => 'required'
        );

        if( !$request->image)
        $required_fields['featured'] = 'required';                

        $validatedData = $request->validate($required_fields);

        if(!$validatedData){
            $error = $v->errors();
            return redirect()->back()->withInput()->withErrors($v->errors());
        }  

        //update master table
        $result = $this->menuItem->updateMenuItem($request);
        //update variants
        $variants = $this->item_variant->updateVariants($request);

        $message = "Item Saved Successfully";
        return redirect('/menuitems')->with('success',$message );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id){
            $item = MenuItem::where('id', $id)->update(['state'=>'-2']);
            return redirect('/menuitems')->with('success', 'Items deleted successfully!');
         }
    }

     /**
     * Remove the specified resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchDelete(Request $request)
    { 
        if( $request->itemlist ){
            if( sizeof($request->itemlist) ){
               $menugroup = MenuItem::whereIn('id', $request->itemlist)->update(['state'=>'-2']);               
               return redirect('/menuitems')->with('success', 'Items deleted successfully!');
            }
        }        
        return redirect('/menuitems')->with('error', 'Please select an item to delete!');
    }

    /**
     * Unpublish 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request){       
        if($request->id){
            $menuItem = MenuItem::findOrFail($request->id);
            $menuItem->state = $request->status;
            if( $menuItem->save() ){
                echo "success"; exit;
            }else{
                echo "fail"; exit;
            }
        }
    }

}
