<?php

namespace App\Http\Controllers\API;


use App\Models\User;
use App\Models\Menugroup;
use App\Models\MenuItem;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MenugroupsCollection;


class MenuController extends BaseController   
{
    

     function __construct(Menugroup $menugroup)
     {
         $this->menugroup = $menugroup;
     } 
    
    public function getmenulist(Request $request){
        
        if(getOutletID()){
             $menugroups = $this->menugroup->getActiveMenuGroups(getOutletID());             
             return new MenugroupsCollection($menugroups);
        }
        return $this->sendError('Invalid Request!'); 
               
    }
    
    public function getitemlist(Request $request){
        
       if($outlet_id = getOutletID()){
           $group_id = $request->get('group_id');
           $result = MenuItem::getMenuItems($outlet_id, $group_id);

           return new MenugroupsCollection($result);
            //$message = "Menu Items";
            //return $this->sendResponse( $result, $message );
       }
       return $this->sendError('Invalid Request!'); 
    }

  

    public function addtocart(Request $request){

    }

    
}
