<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Section;
use App\Http\Requests\AttributeFormRequest;

class AttributesController extends Controller
{
    //
    function __construct(Attribute $attribute,Section $section){
        $this->attribute = $attribute;
        $this->section = $section;
    }
    public function index(Request $request)
    {
        $search_text = $request->has('search_txt') ? $request->get('search_txt') : "";
        $filter_state = $request->has('filter_state') ? $request->get('filter_state') : "";
        $attributes = $this->attribute->getAllAttributes($search_text,$filter_state);
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $sections = $this->section->getActiveSections();
        return view('admin.attributes.create', compact('sections'));
    }

    

    public function store(AttributeFormRequest $request)
    {
        
        $validData = $request->validated();
        if($validData){
            $result = $this->attribute->store($validData);
            return redirect('attributes')->with('success', 'Attribute Created Successfully');
        }
    }

    public function edit($id)
    {   
        $attribute = $this->attribute->find($id);
        $sections = $this->section->getActiveSections();
        return view('admin.attributes.edit',compact('sections','attribute'));
    }

    public function update(AttributeFormRequest $request )
    {
        $validData = $request->validated();
        
        if($validData){
            $validData['id'] = $request->get('id');
            $result = $this->attribute->updateData($validData);
            return redirect('attributes')->with('success', 'Attribute updated Successfully');
        }
    }

    public function delete($id)
    {   
        $result = $this->attribute->updateState($id,'-2');
        return redirect('attributes')->with('success', 'Attribute deleted Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchDelete(Request $request)
    {
        if( $request->attributelist ){
            if( sizeof($request->attributelist) ){
               $this->attribute->batchDelete($request->attributelist);
               return redirect('attributes')->with('success', 'Selected attributes deleted successfully!');
            }
        }
        else{
            return redirect('attributes')->with('error', 'Please select an item to delete!');
        }

    }
}
