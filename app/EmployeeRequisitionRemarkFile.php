<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequisitionRemarkFile extends Model
{
    protected $table = 'employee_requisition_remark_files';
    protected $fillable = [
    	'ereq_no',
        'e_remark_id',
        'filename',
        'encryptname',
        'uploaded_by'
    ];

    public function uploader()
    {
    	return $this->hasOne('App\User','id','uploaded_by');
    }
    public function request()
    {
    	return $this->hasOne('App\EmployeeRequisition','ereq_no','ereq_no');
    }
    public function theremarks()
    {
    	return $this->hasOne('App\EmployeeRequisitionRemark','id','e_remark_id');
    }
    public static function findByEReqNo($id)
    {
    	return self::where('ereq_no',$id)->groupBy('e_remark_id')->orderBy('created_at','DESC')->get();
    }
    public static function ByEncryptName($name){

        return self::where('encryptname',$name)->first();
    }
}
