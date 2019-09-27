<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequisitionRemark extends Model
{
    protected $table = 'employee_requisition_remarks';
    protected $fillable = [
    	'ereq_no','remark','user_id'
    ];

    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }
    public function request()
    {
    	return $this->hasOne('App\EmployeeRequisition','ereq_no','ereq_no');
    }
    public function files()
    {
        return $this->hasMany('App\EmployeeRequisitionRemarkFile','e_remark_id','id');
    }
    public static function findByEReqNo($id)
    {
        return self::where('ereq_no',$id)->orderBy('created_at','DESC')->get();
    }
}
