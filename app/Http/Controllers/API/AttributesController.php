<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Http\Controllers\API\BaseController as BaseController;

class AttributesController extends BaseController
{
    //
    function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function attributes(Request $request,$section)
    {
        if(getOutletID()){
           $attributes = $this->attribute->getCustomAttributes(getOutletID(),$section);
           return $this->sendResponse($attributes, 'Attributes Fetched Successfully'); 
        }
        return $this->sendError('Invalid Request! No data Available');

    }
}
