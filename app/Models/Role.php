<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use DB;

class Role extends Model
{
	protected $fillable = ['title', 'role_description' ];


	public function users(){
		return $this->belongsTo(User::class,'role_users');
	}


		
	public static function deleteRoles( $roles){

		if( sizeof(array_filter($roles)) ){
			$delete_roles = DB::table('roles')
						->leftJoin('users','users.role','=','roles.id')
						->where('roles.is_removable','=','y')
						->where('roles.is_admin','=','0')
						->whereNull('users.role')									
						->select('roles.id')->get();
						$delete_roles = array_column($delete_roles->toArray(),'id');

						//get the roles without user
						$update_role_id = array_intersect($roles,$delete_roles); 

						if( sizeof($update_role_id) > 0 && Role::whereIn('id', $update_role_id)->update(['state'=>'-2']) )						
						return true;
						else						
						return false;
		}else{
			return false;
		}
	}
		
	public static function getDefaultRole(){   

		$result = DB::table('roles')
				->where('is_removable','n')
				->where('is_admin', 0)
				->pluck('id');                
		if ( sizeof($result)){ 
		return $result[0]; 
		}       
		
	}


	public static function createRole(){

		//$request = request();
		$title = request('title');
		$desc = request('description','');
		$role_id = request('role_id',''); 
		$is_removable =   request('is_removable','y');
		$is_admin =   request('is_admin','0');   
		$permissions =   request('permissions');   
		$is_exist_count = Role::is_role_exists($title,$role_id);        				
		
		if($title){                        
			$newrole = array(			
				'title' => $title,
				'role_description' => $desc,
				'is_removable' => $is_removable,
				'is_admin'=>$is_admin,
				'permissions'=>json_encode($permissions)
			);
			
			if( $role_id && $is_exist_count == 0 ){
					$result = DB::table('roles')
						->where('id', $role_id)
						->update($newrole);
				return true;            
			}elseif( $is_exist_count == 0){                
				$result = DB::table('roles')->insert($newrole);                				
				return true;
			}else{
				return false;
			}		
		}else{
			return false;	
		}	
	}

	public static function is_role_exists($role_title,$id){        
		if($role_title){                        
			$resultset = DB::table('roles')
					->where('title',$role_title)
					->where('id', '!=', $id)
					->get()
					->count();
					
			return $resultset;
		}
	}

	public function hasAccess(array $permissions):bool{
		
		foreach ($permissions as $permission) {
			if ($this->hasPermission($permission))
			return true;		
		}

		return false;
	}

	public function hasPermission(string $permission){
		return $this->permissions[$permission]?? false;
	}

     
}
