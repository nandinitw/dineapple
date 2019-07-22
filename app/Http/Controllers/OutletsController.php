<?php

namespace App\Http\Controllers;
use Auth;
use Validator;
use App\Models\Outlet;
use App\Models\OauthClients;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OutletsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $outlets = Outlet::getAllOutlets($request);
        return view('admin.outlets.index', compact('outlets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $hotels = Hotel::all('id','name');
        return view('admin.outlets.create',compact('hotels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required|min:5',
            'hotel_id'=> 'required',
            'image' =>'required'           
        ]);

        if( $validator->fails() ){
            return back()->withErrors($validator)->withinput();
        }else{
            $outlet = new Outlet();
            $outlet->name = $request->name;
            $outlet->hotel_id = $request->hotel_id;
            $outlet->outlet_slug = 'test';
            $outlet->outlet_order = 1;            
            $outlet->created_user_id = Auth::id();
            $outlet->updated_user_id = Auth::id();
            $outlet->is_deleted  = 1;
            $featured_image  = $request->input('image');

            if($featured_image != '' && !file_exists(storage_path('app/public/media').'/'.$featured_image) ){
                if(copy('temp/'.$featured_image, storage_path('app/public/media').'/'.$featured_image)){
                    unlink ('temp/'.$featured_image);
                }
                
                $outlet->outlet_image = $outlet->outlet_primary_image =  $featured_image;
            }


            if( $outlet->save() ){
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
                $message = 'Outlet message';   
            }else{
                $message = 'Error message';   
            }
           
            return redirect('/outlets')->with('message',$message );
          // return redirect('/outlets/'.$outlet->id.'/edit')->with('message', $message);
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
    public function edit($id)
    {        
        $outlet = Outlet::findOrFail($id);
        $hotels = Hotel::all();
        return view('admin.outlets.edit',compact('outlet','hotels'));        
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
        $outlet = Outlet::findOrFail($request->id);
        $outlet->name = $request->name;
        $outlet->hotel_id = $request->hotel_id;
        $outlet->outlet_slug = 'test';
        $outlet->outlet_order = 1;            
        $outlet->created_user_id = Auth::id();
        $outlet->updated_user_id = Auth::id();
        $outlet->is_deleted  = 1;
        $featured_image  = $request->input('image');

        if($featured_image != '' && !file_exists(storage_path('app/public/media').'/'.$featured_image) ){
            if(copy('temp/'.$featured_image, storage_path('app/public/media').'/'.$featured_image)){
                unlink ('temp/'.$featured_image);
            }            
            $outlet->outlet_image = $outlet->outlet_primary_image =  $featured_image;
        }


        $message = ($outlet->save())? 'Outlet message' : 'Error message'; 

        return redirect('/outlets')->with('message',$message );
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
            $item = Outlet::where('id', $id)->update(['state'=>'-2']);
            return redirect('/outlets')->with('success', 'Items deleted successfully!');
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
               $menugroup = Outlet::whereIn('id', $request->grouplist)->update(['state'=>'-2']);               
               return redirect('/outlets')->with('success', 'Items deleted successfully!');
            }
        }        
        return redirect('/outlets')->with('error', 'Please select an item to delete!');
    }


    /**
     * get outlets controller for dropdown
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function outlets(Request $request){
        
        $outlets = Outlet::where('hotel_id',$request->item)
                            ->where('status','Y')
                            ->select('id','name')
                            ->get();
                            
        $outlets = $outlets->toArray();
        echo json_encode($outlets);
        exit;        
    }


    public function updateStatus(Request $request){
       
        if($request->id){
            $hotel = Outlet::findOrFail($request->id);
            $hotel->status = $request->status;
            if( $hotel->save() ){
                echo "success"; exit;
            }else{
                echo "fail"; exit;
            }
        }
    }


 
}
