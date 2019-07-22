<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableDevice extends Model
{
    //
    protected $table = "tables_devices";

    protected $fillable = [
        'outlet_id',
        'table_id',
        'device_id',
        'state'
    ];

    public function mapTableToDevice($outlet_id,$table_id,$device_id)
    {
        $result = $this->create(
            [
                'outlet_id' => $outlet_id,
                'table_id'  => $table_id,
                'device_id' => $device_id,
                'state'     => '1'
            ]
        );
        $result->touch();
        $result->save();
        return $result;
    }

    public function checkBindingExistsForDeviceInOutlet($outlet_id,$device_id)
    {
        $result =  $this->where('outlet_id',$outlet_id)
                    ->where('device_id',$device_id)
                    ->where('state','1')
                    ->count();
        return $result;
    }

    public function checkIfTableAlreadyMapped($outlet_id,$table_id)
    {
        $count =  $this->where('outlet_id',$outlet_id)
        ->where('table_id',$table_id)
        ->where('state','1')
        ->count();
        return $count;
    }

    public function clearCurrentMapping($table_id, $device_id)
    {
        return $this->where('table_id',$table_id)
                    ->where('device_id',$device_id)   
                    ->update(['state' => '0']);
    }

    public function checkTableDeviceCombinationExists($table_id, $device_id)
    {
        $count =   $this->where('table_id',$table_id)
                        ->where('device_id',$device_id)
                        ->where('state','1')
                        ->count();
        return $count;
    }
}
