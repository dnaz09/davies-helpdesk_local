<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequisitionFile extends Model
{
	protected $table = 'employee_requisition_files';
	protected $fillable = ['ereq_no','filename'];
    
    public function request()
    {
    	return $this->hasOne('App\EmployeeRequisition','ereq_no','ereq_no');
    }
    public static function findByEReqNo($id)
    {
    	return self::where('ereq_no',$id)->orderBy('created_at','DESC')->get();
    }
}
