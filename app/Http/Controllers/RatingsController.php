<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ratings;
use App\Http\Requests\RatingRequest;


class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ratings = Ratings::getAllItems($request);
        return view('admin.ratings.index',compact('ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ratings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RatingRequest $request)
    {        
        if(!$request->validated()){
            return back()->withErrors()->withInput();
        }
        $ratings = new Ratings();
        $ratings->name = $request->name;
        $ratings->rated_by = $request->rated_by;
        $ratings->type = $request->type;
        $ratings->options = $request->options;
        $ratings->state = '1';

        if( $ratings->save() )
            $message = "Ratings successfully created";
        else
            $message = "Ratings creation error";
        
        return redirect('ratings')->with('message',$message);
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
        $ratings = Ratings::findOrFail($id);        
        return view('admin.ratings.edit',compact('ratings'));

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
        
        $ratings = Ratings::findOrFail($request->id);    
        $ratings->name = $request->name;
        $ratings->rated_by = $request->rated_by;
        $ratings->type = $request->type;
        $ratings->options = $request->options;
        $ratings->state = '1';

        if( $ratings->save() )
            $message = "Successfully Updated";
        else
        $message = "Updation failed";

        return redirect('ratings')->with('message',$message);;

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
            $item = Ratings::where('id', $id)->update(['state'=>'-2']);
            return redirect('/ratings')->with('success', 'Items deleted successfully!');
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
               $menugroup = Ratings::whereIn('id', $request->itemlist)->update(['state'=>'-2']);               
               return redirect('/ratings')->with('success', 'Items deleted successfully!');
            }
        }        
        return redirect('/ratings')->with('error', 'Please select an item to delete!');
    }


    /**
     * Ajax resource update
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request){
        if($request->id){
            $item = Ratings::findOrFail($request->id);
            $item->state = $request->status;
            if( $item->save() ){
                echo "success"; exit;
            }else{
                echo "fail"; exit;
            }
        }
    }
}
