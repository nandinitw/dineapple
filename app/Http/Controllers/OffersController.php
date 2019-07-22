<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\MenuItem;
use Validator;
use App\Http\Requests\OfferRequest;



class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {           
        $offers = Offer::getAllItems($request);        
        return view('admin.offers.index',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $items = MenuItem::all();
        return view('admin.offers.create',compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferRequest $request)
    { 
        
        if( !$request->validated() ){
             return back()->withErrors()->withInput();   
        }else{
            $offer = new Offer();    
            $offer->offer_name = $request->name;
            $offer->item_id = $request->item_id;
            $offer->description = $request->description;
            $offer->discount = $request->discount;
            $offer->limit = $request->limit;
            $offer->state = $request->state;

            if( $offer->save() )
                $message = "Offer successfully created!";
            else
                $message = "Offer save error!";   

            return redirect('/offers/'.$offer->id.'/edit')->with('message',$message);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offer = Offer::findOrFail($id);    
        $items = MenuItem::all();    
        return view('admin.offers.edit', compact('offer','items'));
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
        $offer = Offer::findOrFail($request->id); 
           
        $offer->offer_name = $request->name;
        $offer->item_id = $request->item_id;
        $offer->description = $request->description;
        $offer->discount = $request->discount;
        $offer->limit = $request->limit;
        $offer->state = $request->state;
        $offer->save();
     
        return redirect('/offers')->with('success', 'Successfully updated!');
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
            $item = Offer::where('id', $id)->update(['state'=>'-2']);
            return redirect('/offers')->with('success', 'Items deleted successfully!');
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
               $menugroup = Offer::whereIn('id', $request->grouplist)->update(['state'=>'-2']);               
               return redirect('/offers')->with('success', 'Items deleted successfully!');
            }
        }
        else{
            return redirect('/offers')->with('error', 'Please select an item to delete!');
        }
    }
    
 

    public function updateStatus(Request $request){
        if($request->id){
            $item = Offer::findOrFail($request->id);
            $item->state = $request->status;
            if( $item->save() ){
                echo "success"; exit;
            }else{
                echo "fail"; exit;
            }
        }
    }

}
