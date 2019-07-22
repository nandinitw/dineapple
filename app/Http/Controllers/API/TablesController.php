<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\TableDevice;
use App\Repositories\Tables\TableRepository;
use App\Repositories\Tables\Table;
use App\Http\Resources\TablesCollection;


class TablesController extends BaseController
{
    //
    function __construct(TableRepository $table)
    {
        $this->table = $table;
    }

    public function index(Request $request)
    {
        
       if(getOutletID()){
           $tables = Table::getTablesByOutletID(getOutletID());
           return new TablesCollection($tables);
       }
       return $this->sendError('Invalid Request! No data Available');
    }


}
