<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderRemark extends Model
{
    protected $table = 'job_order_remarks';
    protected $fillable = [
    	'jo_id',
    	'remark',
    	'user_id'
    ];

    public function jo()
    {
    	return $this->hasOne('App\JobOrder', 'id', 'jo_id');
    }
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function files()
    {
        return $this->hasOne('App\JobOrderRemarkFile', 'jo_remark_id', 'id');
    }
    public static function byJOId($id)
    {
        return self::where('jo_id', $id)->orderBy('created_at','ASC')->get();
    }
    public static function getList($id)
    {
        $remarks = self::where('jo_id',$id)->orderBy('created_at','DESC')->get();
        foreach ($remarks as $key => $value) {
            
            $files = JobOrderRemarkFile::where('jo_remark_id',$value->id)->get();

            $remarks[$key]->files = $files;
        }
        return $remarks;
    }
}
