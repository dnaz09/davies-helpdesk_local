<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequisitionDetail extends Model
{
    protected $table = 'employee_requisition_details';
    protected $fillable = [
    	'ereq_no','hr_receiver','hr_manager_action','hr_manager','reco_approval','reco_approver'
    ];

    public function hrd()
    {
    	return $this->hasOne('App\User','id','hr_receiver');
    }
    public function recommendor()
    {
    	return $this->hasOne('App\User','id','reco_approver');
    }
    public static function findByEReqNo($id)
    {
        return self::where('ereq_no',$id)->first();
    }
}
