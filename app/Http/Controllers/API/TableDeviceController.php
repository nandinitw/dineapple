<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\TableDevice;

class TableDeviceController extends BaseController
{
    //
    function __construct(TableDevice $table_device)
    {
        $this->table_device = $table_device;
    }
    public function mapdevicetotable(Request $request)
    {
        if(getOutletID()){
            $outlet_id = getOutletID();
            $table_id = $request->get('table_id');
            $device_id = $request->get('device_id');
            if($outlet_id && $table_id && $device_id){
                if($this->checkBindingExists($outlet_id,$table_id,$device_id)){
                    return $this->sendError('This device as been already mapped to a table.Please clear this setting.'); 
                }
                if($this->checkTableAlreadyMapped($outlet_id,$table_id,$device_id)){
                    return $this->sendError('This table has been already mapped to another device'); 
                };
                $result = $this->table_device->mapTableToDevice($outlet_id,$table_id,$device_id);
                return $this->sendResponse($result,"Device Mapped Successfully");
            }
            return $this->sendError('A few parameters are invalid');
        }
        return $this->sendError('Invalid Request!');
    }

    public function clearmappings(Request $request)
    {
       if(getOutletID())
       {
            $outlet_id = getOutletID();
            $table_id = $request->get('table_id');
            $device_id = $request->get('device_id');
            if($outlet_id && $table_id && $device_id){
                if($this->checkTableDeviceCombinationExists($table_id,$device_id) == 0){
                    return $this->sendError('This table device combination does not exist.'); 
                }
                $result = $this->table_device->clearCurrentMapping($table_id,$device_id);
                return $this->sendResponse([],"Settings Cleared Successfully");
            }
                
       }
       return $this->sendError('Invalid Request! Few paramaters are invalid');
    }

    public function checkTableDeviceCombinationExists($table_id,$device_id)
    {
        $flag = 0;
        if($this->table_device->checkTableDeviceCombinationExists($table_id,$device_id) > 0){
            $flag = 1;
        }
        return $flag;
    }

    public function checkBindingExists($outlet_id,$table_id,$device_id)
    {
        $flag = 0;
        if($this->table_device->checkBindingExistsForDeviceInOutlet($outlet_id,$device_id) > 0){
            $flag = 1;
        }
        return $flag;
    }

    public function checkTableAlreadyMapped($outlet_id,$table_id,$device_id)
    {
        $flag = 0;
        if($this->table_device->checkIfTableAlreadyMapped($outlet_id,$table_id) > 0){
            $flag = 1;
        }
        return $flag;
    }
}
