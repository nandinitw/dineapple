<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Role;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\RatingAnswer;
use App\Models\Ratings;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','api_token','mobile','role','hotel_id','outlet_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function createOrUpdateUser($data, $user_id){
        
        if($user_id){
            User::find($user_id)->fill($data)->save();   
            /*DB::table('role_users')
            ->where('user_id', $user_id)
            ->update(['role_id' => $data['role'], 'updated_at'=>now() ]);*/
        }else{            
            $user = User::create($data);
            /*$role_user = array(
               'role_id'=>$data['role'], 'user_id'=>$user->id
            ); 
            DB::table('role_users')->insert($role_user);*/
        }

        return true;
    }

    public function roles()
    {        
        return $this->hasOne(Role::class);       
    }

    public function orders()
    {        
        return $this->hasMany(Order::class);       
    }

    public function hasAccess(array $permissions):bool{

        foreach($this->role as $role){
                if($role->hasAccess($permissions)){
                    return true;
                }
        }
        return false;
    }

    public function inRole(string $roleSlug)
    {
        return $this->roles()->where('slug', $roleSlug)->count() == 1;
    }

    public function outlet()
    {        
        return $this->belongsTo('App\Models\Outlet');
    }

    public function items()
    {        
        return $this->hasMany(OrderItems::class);       
    }

    public function getCustomers($request){

        $outlet_id = $request->has('outlet')? $request->get('outlet') : "";
        $query = $this->where('state', '>','-2')
                      ->where('role','4') ;
        if($outlet_id != ""){
            $query->where('outlet_id',$outlet_id);
        }
        return $query->orderby('updated_at','desc')->get();
    }

    public function getUsersCount()
    {
        return $this->where('state', '>','-2')->count();
    }

    public function getRecentUsers()
    {
        return $this->where('state', '>','-2')
                    ->orderby('updated_at','DESC')
                    ->take(5)
                    ->get();
    }

    public function getWaiters($request){

        $roles = ['1','2','3'];
        $outlet_id = $request->has('outlet')? $request->get('outlet') : "";
        $query = $this->where('state', '>','-2')
                      ->whereIn('role',$roles) ;
        if($outlet_id != ""){
            $query->where('outlet_id',$outlet_id);
        }
        $result = $query->get();
        return $result;
    }

    public function getRatingAnswersOfCustomers($id,$request)
    {
        $outlet_id = $request->has('outlet')? $request->get('outlet') : "";
        $roles_arr = ['1','3'];
        $results  =   $this->join('ratings_answers','ratings_answers.rated_by','=','users.id')
                         ->join('ratings','ratings.id','=','ratings_answers.rating_id')
                         ->select('users.email','ratings_answers.*','ratings.name')   
                         ->where('ratings_answers.state', '>','-2')
                         ->where('ratings_answers.rated_by', $id)
                         ->whereIn('users.role',$roles_arr) 
                         ->get();
       //dd($results);
        return $results;
    }

}
