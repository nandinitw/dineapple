<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;

class OutletController extends Controller
{
    public function outlets(Request $request){
        
        $outlets = Outlet::where('hotel_id',$request->item)
                            ->where('state','1')
                            ->select('id','name')
                            ->get();
                            
        $outlets = $outlets->toArray();
        echo json_encode($outlets);
        exit;        
    }
}
