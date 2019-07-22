<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /*$table_rule = "required|unique:tables|max:255";
        if($this->request->get('id')){
            $table_rule = "required|max:255";
        }*/
        return [
            'table_name'    => 'required|max:255',
            'no_of_persons' => 'required',
            'hotel'         => 'required',
            'outlet'        => 'required',
            'state'         => 'required'    
        ];
    }
}
