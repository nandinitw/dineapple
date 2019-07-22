<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;
use App\Models\Hotel;
use App\Http\Requests\PagesRequest;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pages = Page::getAllPages($request);
        return view('admin.pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {        
        $hotels = Hotel::getAllHotels($request);
        return view('admin.pages.create', compact('hotels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PagesRequest $request)
    {
        if(!$request->validated()){
            return back()->withErrors()->withInput();
        }else{
            $page = new Page();
            $page->hotel_id = $request->hotel_id;
            $page->title = $request->title;
            $page->slug = str_slug( ($request->slug)? $request->slug : $request->title ) ;
            $page->description = $request->description;
            $page->state = 1;

            if( $page->save() )
                $message = "Pages successfully created";
            else
                $message = "Pages creation error";

            
            return redirect('/pages/'.$page->id.'/edit')->with('message',$message);
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
    public function edit(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $hotels = Hotel::getAllHotels($request);
        return view('admin.pages.edit',compact('page','hotels'));

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
        $page = Page::findOrFail($request->id);
        $page->hotel_id = $request->hotel_id;
        $page->title = $request->title;
        $page->slug = str_slug( ($request->slug)? $request->slug : $request->title ) ;
        $page->description = $request->description;
        $page->save();

        return redirect('/pages')->with('success','Pages updated');        
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
            $item = Page::where('id', $id)->update(['state'=>'-2']);
            return redirect('/pages')->with('success', 'Item deleted successfully!');
         }
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchDelete(Request $request)
    { 
        if( $request->grouplist ){
            if( sizeof($request->grouplist) ){
               $menugroup = Page::whereIn('id', $request->grouplist)->update(['state'=>'-2']);               
               return redirect('/pages')->with('success', 'Items deleted successfully!');
            }
        }      
        return redirect('/pages')->with('error', 'Please select an item to delete!');
    }


    /**
     * Ajax resource update
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request){
        if($request->id){
            $item = Page::findOrFail($request->id);
            $item->state = $request->status;
            if( $item->save() ){
                echo "success"; exit;
            }else{
                echo "fail"; exit;
            }
        }
    }
}
