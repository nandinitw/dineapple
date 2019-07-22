<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Menugroup;
use App\Models\MenuItem;
use App\Models\Hotel;
use App\Models\Outlet;
use Session;
use DB;
use Illuminate\Support\Str;

class MenugroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $menugroups = Menugroup::getAllItems($request);
        $outlet_id =  $request->has('outlet') ? $request->get('outlet') : "";
        return view('admin.menugroups.index', compact('menugroups','outlet_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $hotels = Hotel::getHotelsList();
        $outlets = Outlet::all('id','name');
        $hotel_id =  $request->has('hotel') ? $request->get('hotel') : "";
        $outlet_id =  $request->has('outlet') ? $request->get('outlet') : "";
        return view('admin.menugroups.create',compact('hotels','outlets','hotel_id','outlet_id'));
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
            'name' => 'required|min:5|unique:menu_groups,name,'.($request->id ?? null),
            'hotel'=>'required',
            'outlet'=>'required',
        );
        if( !$request->image){
            $required_fields['featured'] = 'required';
        }
        $validatedData = $request->validate($required_fields);

            if(!$validatedData){
                $error = $v->errors();
                return redirect()->back()->withInput()->withErrors($v->errors());
            }else{

                if( $request->id ){
                    $menuGroup = Menugroup::find($request->id);
                }else{
                    $menuGroup = new Menugroup;
                }
                $menuGroup->name = $request->name;
                $menuGroup->group_slug = Str::slug($request->name, '-');
                $menuGroup->description = $request->description;
                $menuGroup->hotel_id = $request->hotel;
                $menuGroup->outlet_id = $request->outlet;
                $featured_image  = $request->input('image');

                if($featured_image != '' && !file_exists(storage_path('app/public/media').'/'.$featured_image) ){
                        if(copy('temp/'.$featured_image, storage_path('app/public/media').'/'.$featured_image)){
                            unlink ('temp/'.$featured_image);
                        }
                        $menuGroup->image = $featured_image;
                }

                if($menuGroup->save()){
                    $message = 'Menu group has been created/updated.';
                }else{
                    $message = 'Menu group already exists!';
                }
                return redirect('/menugroups')->with('success',$message );
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
        $menugroup = Menugroup::findOrFail($id);        
        $menu = $menugroup->toArray();

        $hotel_id = $menu['hotel_id'];

        $hotels = Hotel::getHotelsList();
        $outlets = $this->getoutlets($hotel_id);
        return view('admin.menugroups.edit', compact('menugroup','hotels','outlets') );
    }

    public function getoutlets($hotem){
        $outlets = Outlet::where('hotel_id',$hotem)
                            ->where('state','1')
                            ->select('id','name')
                            ->get();

       return $outlets;
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchDelete(Request $request)
    {
       if( $grouplist = $request->input('grouplist') ){
           
            if( sizeof($grouplist) ){

               $parent_items = DB::table('menu_groups as mg')
               ->select('mg.id')
               ->leftjoin('menu_items as mi','mg.id','=','mi.group_id')
               ->whereIn('mg.id',$grouplist )
               ->whereNull('mi.id')
               ->get();
                $menugroups_count = sizeof($parent_items->toArray());

               if( sizeof($grouplist) == $menugroups_count ){

                    $menugroup = Menugroup::whereIn('id', $grouplist )->update( ['state'=>'-2'] );
                    return redirect('menugroups')->with('success', 'Menu groups deleted successfully!');

               }elseif( sizeof($grouplist) > $menugroups_count && $menugroups_count>0 ) {

                    $deleteList = array_column($parent_items->toArray(),'id');
                    $menugroup = Menugroup::whereIn('id', $deleteList )->update( ['state'=>'-2'] );
                    return redirect('menugroups')->with( 'success', $menugroups_count.' Menu group deleted successfully' );

               }else{
                    return redirect('menugroups')->with('error', "Menu groups contains items!");
               }
            }
        }
        else{
            return redirect('menugroups')->with('error', 'Please select a menu group to delete');
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){  

        $delete_Id = $request->id;
        if($delete_Id){

            $parent_items = DB::table('menu_groups as mg')
               ->select('mg.id')
               ->join('menu_items as mi','mg.id','=','mi.group_id')
               ->where('mg.id',$delete_Id )               
               ->count();
             
            if($parent_items==0){                                 
                $menugroup = Menugroup::where('id', $delete_Id )->update(['state'=>'-2']);        
                return redirect('menugroups')->with('success', 'Menu group deleted successfully!');
            }else{
                return redirect('menugroups')->with('error', "Menu group contains items!");   
            }    
        }   

    }


    /**
     * Unpublish 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request){       
        if($request->id){          
            $menugroup = Menugroup::findOrFail($request->id);
            $menugroup->state = $request->status;
            if( $menugroup->save() ){
                echo "success"; exit;
            }else{
                echo "fail"; exit;
            }
        }
    }

}
