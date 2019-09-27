<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    
    protected $fillable = [
        'first_name',
        'middle_initial',
        'last_name',      
        'username',  
        'email',
        'dept_id',    
        'role_id',
        'password',
        'active',
        'super_admin',
        'position',
        'employee_number',
        'image',        
        'mystatus',
        'email_pass',
        'cellno',
        'localno',
        'online', 
        'location_id',
        'company',
        'superior'
        
    ];

    public function role(){

        return $this->hasOne('App\Role','id','role_id');
    }

    public function access(){

        return $this->hasOne('App\AccessControll','user_id','id');
    }

    public function supervisor(){

        return $this->hasOne('App\User','id','superior');
    }

    public function department(){

        return $this->hasOne('App\Department','id','dept_id');
    }

    public function location(){

        return $this->hasOne('App\Location','id','location_id');
    }

    public static function FullDetails(){

        return DB::table('users')->select(DB::raw("CONCAT(first_name,' ',last_name) as full_name ,id"))
                ->where('active',"1")
                ->pluck('full_name','id');
    }

    public static function allActive(){

        return self::where('active',"1")->orderBy('first_name')->get();
    }

    public static function byOnline($id){

        return self::where('online',1)->where('id','!=',$id)->get();
    }

    public static function getSuperior(){

        $ids =  self::select('superior')->where('superior','>',0)->get();

        $idss = self::select('id')->whereIn('role_id',[4,5,7,8,9,11,12,13,14,])->get();

        $uid =[];

        foreach ($ids as $key => $value) {
            $uid[] = $value->superior;
        }

        foreach ($idss as $key => $value) {
            $uid[] = $value->id;
        }

        return DB::table('users')->select(DB::raw("CONCAT(first_name,' ',last_name) as full_name ,id"))
                ->where('active',"1")
                ->whereIn('id',$uid)
                ->orderBy('full_name')
                ->pluck('full_name','id');
    }

    public static function getSupId(){

        $ids =  self::select('superior')->where('superior','>',0)->get();

        $uid =[];

        foreach ($ids as $key => $value) {
            $uid[] = $value->superior;
        }

        return $uid;
    }
    public static function exceptUser($id,$dept_id)
    {
        return self::where('id','!=',1)->where('active',1)->where('id', '!=', $id)->where('dept_id',$dept_id)->get();
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public static function withMessage()
    {
        return self::select('users.*', 'messages.*')
        ->join('messages', 'messages.user_id', '=', 'users.id')
        ->where('users.id', '!=', \Auth::user()->id)
        ->where('online', 1)
        ->get();
    }

    public static function byMessage($id)
    {
        $a = self::select('users.*')
            ->join('messages as m', 'm.user_id', '=', 'users.id')
            ->where('users.id','!=', $id)
            ->orderBy('m.is_seen','DESC')
            ->get();
        if(!empty($a)){
            return $a;
        }else{
            $b = self::where('id','!=',$id)->where('online',1)->get();
            return $b;
        }
    }

    public static function allUser()
    {
        return self::where('id','!=',1)->get();
    }

    public static function getAllSuperiors($id)
    {
        $managers = self::where('role_id',4)
            ->orWhere('role_id',8)
            ->where('id','!=',1)->get();

        return $managers;
    }

    public static function findUserByidandDeptid($id, $dept_id)
    {
        return self::where('id',$id)->where('dept_id',$dept_id)->first();
    }
}
