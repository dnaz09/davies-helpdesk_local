<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GatePassFile extends Model
{
    protected $table = 'gate_pass_files';

    protected $fillable = [
    	'gate_pass_id','filename','user_id'
    ];

    public static function getByGatePassId($id)
    {
    	return self::where('gate_pass_id',$id)->orderBy('created_at','DESC')->get();
    } 
}
