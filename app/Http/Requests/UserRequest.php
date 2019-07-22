<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Auth;
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();  
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $user_id  = $request->input('user_id_hidden');

        if(empty($user_id) ||  !empty($request->input('password')) ){
            return [
                'name' => 'required','email' => 'required','role' => 'required','hotel'=>'required','outlet'=>'required','mobile' => 'required','password' => 'min:6|required_with:password_confirmation|same:password_confirmation','password_confirmation' => 'min:6'
            ];
        }else{
            return [
                'name' => 'required','mobile' => 'required','email' => 'required','hotel'=>'required','outlet'=>'required'
            ]; 
        }
    }
}
