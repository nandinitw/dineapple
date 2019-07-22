<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Role;
use DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {        
        //$roles = Role::all();
        
        $roles = Role::where('is_admin', '!=', 1 )->where('state','>=','0')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$roles = Role::all();
        //return view('user.register', compact('user','roles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {              
            $validatedData= $this->validate(request(),[
             'title' => 'required'                                     
            ]);                           
            if(!$validatedData){                
                $error = $v->errors();
                return redirect()->back()->withInput()->withErrors($v->errors());            
            }else{
                $result = Role::createRole();
                if($result){
                    $status = 'success';
                    $message = 'Roles has been created/updated.';    
                }else{
                    $status = 'error';
                    $message = 'Roles already exists!';
                }                
                return redirect('/roles')->with($status,$message );
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);        
        return view('admin.roles.edit', compact('role') );
    }

  


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchDelete(Request $request)
    {    
        if( $rolelist = $request->input('rolelist') ){
            if( sizeof($rolelist) ){                        
                if( Role::deleteRoles($rolelist) )
                return redirect('roles')->with('success', 'Roles deleted successfully!');
                else
                return redirect('roles')->with('error', 'Roles assigned to user!');
            }    
        }
        else{
            return redirect('roles')->with('error', 'Please select a role to delete');
        }
    }
    
    public function delete(Request $request){     
        $delete_Id = $request->id;  
        if($delete_Id){
            $parent_menu = DB::table('roles as r')
               ->select('r.id')
               ->join('users as u','u.role','=','r.id')
               ->where('r.id',$delete_Id )               
               ->count();
               
        if($parent_menu == 0){        
            $item = Role::where('id', $delete_Id)->update(['state'=>'-2']);
            return redirect('roles')->with('success', 'Role deleted successfully!');
        }else{
            return redirect('roles')->with('error', "User exist in the current role!");   
        }    
        }   
    }

      /**
     * Ajax resource update
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request){
        if($request->id){
            $item = Role::findOrFail($request->id);
            $item->state = $request->status;
            if( $item->save() ){
                echo "success"; exit;
            }else{
                echo "fail"; exit;
            }
        }
    }
}
