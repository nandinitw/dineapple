<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\Ratings;
use App\Models\RatingsOutlets;
use App\Models\Hotel;
use DB;


class AssignratingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $hotels  = Hotel::all()->where('state','1');
        $hotel =  $request->has('hotel') ? $request->get('hotel') : "";
        $outlet =  $request->has('outlet') ? $request->get('outlet') : "";
        $outlets = Outlet::getAllOutlets($request);  
        return view('admin.assignratings.index',compact('outlets','hotels'));
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
        
        $res = RatingsOutlets::where('outlet_id', $request->outlet_id)->delete();
        $addrating = array();
        if( sizeof($request->rating_id) ){
            foreach($request->rating_id as $item){
                $addrating[] = array(
                    'outlet_id'=> $request->outlet_id,
                    'rating_id'=> $item,
                    'state'=>'1'
                );
            }
        }         
        $assigned = DB::table('ratings_outlets')->insert($addrating);
        return redirect('assignratings')->with('success', "Ratings assigned successfully!");
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
        $ratings = Ratings::all()->where('state', 1);
        $assigned = RatingsOutlets::all()->where('outlet_id',$id);
        if( sizeof($assigned->toArray()) ){
            $assigned = $assigned->toArray();
            $assigned = array_column($assigned,'rating_id');
        }

        return view('admin.assignratings.assign', compact('outlet','ratings','assigned'));
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

    
}
