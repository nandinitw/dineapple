<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Outlet;
use App\Models\OauthClients;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HotelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        
        $hotels = Hotel::getAllHotels($request);
        return view('admin.hotel.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.hotel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
         
             $validator = Validator::make($request->all(), [
                'name' => 'required|min:5',
                'featured' => 'required',
            ]);

            if($validator->fails()){    
                return back()->withErrors($validator)->withInput();  
            }else{                                
                $hotel = new Hotel;                                  
                $hotel->name = $request->name;                                
                $hotel->created_user_id =  Auth::id();       
                $hotel->updated_user_id =  Auth::id(); 
                $featured_image = $request->input('image');

                if($featured_image != '' && !file_exists(storage_path('app/public/hotels').'/'.$featured_image) ){
                    if(copy('temp/'.$featured_image, storage_path('app/public/hotels').'/'.$featured_image)){
                        unlink ('temp/'.$featured_image);
                    }
                    $hotel->hotel_image = $featured_image;
                }
                if( $hotel->save() ){
                    //default outlet creation
                    $default_outlet = array(
                        'name'=> $request->name,
                        'outlet_slug'=> Str::slug( 'Default Outlet '.$request->name,'-'),
                        'hotel_id'=>$hotel->id,
                        'created_user_id'=>Auth::id(),
                        'updated_user_id'=>Auth::id(),
                        'state'=>'1',
                    );
                   
                   if(  $outlet = Outlet::create($default_outlet) ){
                        //outlet Oauth creation
                        $oauthclient = array(
                            'outlet_id'=> $outlet->id,
                            'name'=>$request->name,
                            'secret'=> Str::random(40),                        
                            'personal_access_client'=> 0,
                            'redirect'=> 'http://localhost',
                            'password_client'=> 1
                        );
                        OauthClients::create($oauthclient);
                   }                    
                    $message = 'Successfully saved';
                }else{
                    $message = 'Save failed';
                }

            }     
           return redirect('/hotels')->with('message', $message);                         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {       
        $hotel = Hotel::find($id);  
        return view('admin.hotel.edit',compact('hotel'));     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        $hotel_id = $request->id;              
        $hotel = Hotel::findOrFail($hotel_id);
        $hotel->name = $request->name;                                
        //$hotel->created_user_id =  Auth::id();       
        $hotel->updated_user_id =  Auth::id(); 
        $featured_image = $request->input('image');

        if($featured_image != '' && !file_exists(storage_path('app/public/hotels').'/'.$featured_image) ){
            if(copy('temp/'.$featured_image, storage_path('app/public/hotels').'/'.$featured_image)){
                unlink ('temp/'.$featured_image);
            }
            $hotel->hotel_image = $featured_image;
        }

        if( $hotel->save() )
            $message = "Successfully update!";
        else
            $message = "Update failed";

        return redirect('/hotels')->with('message', $message);      
        
    }

    public function updateStatus(Request $request){
        
        if($request->id){
            $hotel = Hotel::findOrFail($request->id);
            $hotel->state = $request->status;
            if( $hotel->save() ){
                echo "success"; exit;
            }else{
                echo "fail"; exit;
            }
        }
    }
     

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
        if($id){
            $item = Hotel::where('id', $id)->update(['state'=>'-2']);
            return redirect('/hotels')->with('success', 'Items deleted successfully!');
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
        if( $request->grouplist ){
            if( sizeof($request->grouplist) ){
               $menugroup = Hotel::whereIn('id', $request->grouplist)->update(['state'=>'-2']);               
               return redirect('/hotels')->with('success', 'Items deleted successfully!');
            }
        }        
        return redirect('/hotels')->with('error', 'Please select an item to delete!');
    }

}
