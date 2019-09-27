<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderRemarkFile extends Model
{
    protected $table = 'job_order_remark_files';
    protected $fillable = [
    	'jo_id','jo_remark_id','filename','uploaded_by'
    ];

    public function jo()
    {
    	return $this->hasOne('App\JobOrder', 'id', 'jo_id');
    }
    public function remark()
    {
    	return $this->hasOne('App\JobOrderRemark', 'id', 'jo_remark_id');
    }
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'uploaded_by');
    }
    public static function ByEncryptName($name){

        return self::where('encryptname',$name)->first();
    }
}
