<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Hotel;
use App\Models\Outlet;
use App\Models\Module;
use DB;
use Auth;
use Redirect;


class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "Registered Users";
        $search_txt = $request->search_txt;
        $role_filter = $request->filter_role;
        $outlet_id =  $request->has('outlet') ? $request->get('outlet') : "";
        //$users = User::all();

         $query_users =  User::query()->from('users as u')
            ->select('u.id', 'u.name','u.email','r.title as role','u.role as roleId','u.created_at')
            ->leftJoin('roles as r','r.id','=','u.role')
         
            ->where('u.state','>=','0')
            ->orderBy('u.name','asc');

        if($role_filter)
              $query_users->where('u.role', $role_filter );

          if($search_txt){
              $query_users->where('u.name','like', '%'.$search_txt.'%');
              $query_users->orWhere('u.email','like', '%'.$search_txt.'%');
          }
          if($outlet_id !=""){
            $query_users->where('u.outlet_id', $outlet_id ); 
          }
          $users = $query_users->paginate(20);

          $roles = Role::all();

        return view('admin.user.index', compact('users','title','roles','role_filter'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = "";
        $hotels = Hotel::getHotelsList();
        $roles = Role::where('is_admin', '!=', 1 )->get();
        $hotel_id =  $request->has('hotel') ? $request->get('hotel') : "";
        $outlet_id =  $request->has('outlet') ? $request->get('outlet') : "";
        return view('admin.user.register', compact('user','roles','hotels','hotel_id','outlet_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
            if(!$request->validated()){
                return redirect()->back()->withInput()->withErrors($v->errors());
            }            
            $user_id  = $request->input('user_id_hidden');
            $exist_email = $this->validateEmail($user_id,'email',$request->input('email'));            
            if($exist_email){
                return redirect('users')->with('success', 'User email exists!!');
            }  

            $user = array(
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'role' => $request->input('role'),
                'hotel_id'=> $request->input('hotel'),
                'outlet_id'=> $request->input('outlet'),
                'api_token' => Str::uuid(),    
                'password' => Hash::make($request->input('password'))
            );
            User::createOrUpdateUser($user,  $user_id);
            return redirect('users')->with('success', 'User has been created');

    }

    public function validateEmail($user_id,$field,$input_data)
	{
		if( empty($user_id) ){
            $query = User::where($field, '=', $input_data)->get();
		}else{
            $query = User::where('id', '!=', $user_id)
                    ->where($field, '=', $input_data)
                    ->get();
		}
        $count = $query->count();
		if( $count >0 ){
			return true;
		}else{
			return false;
		}
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {        
        $user = User::find($id);
        $hotels = Hotel::getHotelsList();

        $outlets = array();
        if( $hotel_id = $user->hotel_id )         
        $outlets = $this->getoutlets($hotel_id);

        $roles = Role::where('is_admin', '!=', 1 )->where('state','>=','0')->get();
        return view('admin.user.edit', compact('user','roles','hotels','outlets') );
    }


    /**
     * function to get outlet
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getoutlets($hotem){
        $outlets = Outlet::where('hotel_id',$hotem)
                            ->where('state','1')
                            ->select('id','name')
                            ->get();

       return $outlets;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
            if(!$request->validated()){
                return redirect()->back()->withInput()->withErrors($v->errors());
            }

            $exist_email = $this->validateEmail($user_id,'email',$request->input('email'));
            if($exist_email){
                return redirect('users')->with('success', 'User email exists!!');
            }

            $user = array(
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'role' => $request->input('role'),
                'hotel_id'=> $request->input('hotel'),
                'outlet_id'=> $request->input('outlet'),                
                'password' => Hash::make($request->input('password'))
            );            
            if( empty($request->input('password')) ){ 
                unset($user['password']);
            }
           
            User::createOrUpdateUser($user,  $user_id);
            return redirect('users')->with('success', 'User has been created.');
    }

    /**
     * batchDelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchDelete(Request $request)
    {
        if( $userlist = $request->input('userlist') ){
            if( sizeof($userlist) ){
                DB::table('users')->whereIn('id', $userlist)->delete();
                return redirect('users')->with('success', 'User deleted successfully!');
            }
        }else{
            return redirect('users')->with('error', 'Please select a user to delete');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
      //  redirect('/');
    }

    public function useraccess(){
        //$userlist = User::all();
        $userlist = DB::table('users as u')
        ->select('u.id','u.email')
        ->where('u.role', '!=',  1 )
        ->orderBy('u.name','asc')
        ->get();

        $modulelist = Module::all();
        $user_modules = Module::getAssignedModules();
        return view('admin.user.useraccess', compact('userlist','modulelist','user_modules'));

    }

    public function assignmodules(){
		//saving
		$result = Module::setuserModules();
        if($result){
		   $message = "User access established!";
		}else{
		   $message = "Please select a user to assign modules!";
		}
        return redirect('useraccess')->with('success', $message);
	}
 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    { 
  
        $outlet = User::where('id', $request->id )->update(['state'=>'-2']);
        return redirect('users')->with('success', "Successfully deleted!");   
    }

}
