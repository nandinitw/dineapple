<?php

namespace App\Http\Controllers\Manage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Tables\TableRepository;
use App\Http\Requests\TableFormRequest;
use App\Models\Hotel;
use App\Models\Outlet;
use App\Models\Table;

class TablesController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct(TableRepository $table,Hotel $hotel,Outlet $outlet){
        $this->table = $table;
        $this->hotel = $hotel;
        $this->outlet = $outlet;
    }
    public function index(Request $request)
    {
       $search_text = $request->has('search_txt') ? $request->get('search_txt') : "";
       $filter_state = $request->has('filter_state') ? $request->get('filter_state') : "";
       $outlet_id =  $request->has('outlet') ? $request->get('outlet') : "";
       $tables = $this->table->all($search_text,$filter_state,$outlet_id);
       return view('admin.tables.index', compact('tables','outlet'));
    }

    public function create(Request $request)
    {    
        
        $hotels = $this->hotel->getAllHotels();
        $outlets = $this->outlet->getOutlets();
        $hotel_id =  $request->has('hotel') ? $request->get('hotel') : "";
        $outlet_id =  $request->has('outlet') ? $request->get('outlet') : "";
        return view('admin.tables.create',compact('hotels','outlets','hotel_id','outlet_id'));
    }

    public function store(TableFormRequest $request)
    {
        $validData = $request->validated();
        if($validData){
            $result = $this->table->store($validData);
            return redirect('manage/tables')->with('success', 'Table Created Successfully');
        }
    }

    public function edit($id,Request $request)
    {   
        $table = $this->table->getTableDetails($id);
        $hotels = $this->hotel->getAllHotels();
        $hotel_id = $table->outlet->hotel->id;
        $outlets = $this->outlet->getOutlets($hotel_id);
        $hotel =  $request->has('hotel') ? $request->get('hotel') : "";
        $outlet =  $request->has('outlet') ? $request->get('outlet') : "";
        return view('admin.tables.edit',compact('hotels','outlets','table','hotel','outlet'));
    }

    public function update(TableFormRequest $request )
    {
        $validData = $request->validated();
        if($validData){
            $validData['id'] = $request->get('id');
            $result = $this->table->update($validData);
            return redirect('manage/tables')->with('success', 'Table updated Successfully');
        }
    }

    public function delete($id)
    {   
        $result = $this->table->updateState($id,'-2');
        return redirect('manage/tables')->with('success', 'Table deleted Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchDelete(Request $request)
    {
        if( $request->tablelist ){
            if( sizeof($request->tablelist) ){
               $this->table->batchDelete($request->tablelist);
               return redirect('manage/tables')->with('success', 'Selected tables deleted successfully!');
            }
        }
        else{
            return redirect('manage/tables')->with('error', 'Please select an item to delete!');
        }

    }
    
}
