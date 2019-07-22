<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Outlet;
use App\Models\Attribute;
use App\Models\AttributesOutlets;
use App\Models\Section;
use DB;

class AssignAttributesController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct(Attribute $attribute,Section $section,AttributesOutlets $attribute_outlet,Outlet $outlet){
        $this->attribute = $attribute;
        $this->section = $section;
        $this->attribute_outlet = $attribute_outlet;
        $this->outlet = $outlet;
    }
    
    public function index(Request $request)
    {  
    
        $hotels  = Hotel::all()->where('state','1');
        $hotel =  $request->has('hotel') ? $request->get('hotel') : "";
        $outlet =  $request->has('outlet') ? $request->get('outlet') : "";
        $outlets = Outlet::getAllOutlets($request);  
        return view('admin.assignattributes.index',compact('outlets','hotels','hotel','outlet'));
    }

    public function edit($id)
    {
        $outlet = $this->outlet->findOrFail($id);        
        $sections = $this->section->getActiveSections();
        $assigned = $this->attribute_outlet->getAttributesForOutlet($id);        

        return view('admin.assignattributes.assign', compact('outlet','assigned','sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $result = $this->attribute_outlet->assignAttributes($request);
        return redirect('assignattributes')->with('success', "Attributes assigned successfully!");
    }


}
