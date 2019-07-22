<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Http\Controllers\API\BaseController as BaseController;
use DB;
use App\Http\Resources\Outlet as OutletResource;


class OutletController extends BaseController   
{
    
    function __construct(Outlet $outlet)
    {
        $this->outlet = $outlet;
    }
    
    public function index(Request $request)
    {
        if(getHotelID()){
            $outlets =  $this->outlet->getAllOutlets(getHotelID());
            return OutletResource::collection($outlets);
        }
        return $this->sendError('Invalid Request!');
        
    }
}
