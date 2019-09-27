<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GatePassRemark extends Model
{
    protected $table = 'gate_pass_remarks';

    protected $fillable = [
    	'gate_pass_id','remark','user_id'
    ];

    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }

    public static function getByGatePassId($id)
    {
    	return self::where('gate_pass_id',$id)->orderBy('created_at','DESC')->get();
    }
}
