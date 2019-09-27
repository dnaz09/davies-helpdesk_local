<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnouncementMember extends Model
{
    protected $table = 'announcement_members';

    protected $fillable = [
    	'ann_id','dept_id'
    ];

    public function department()
    {
    	return $this->hasOne('App\Department','id','dept_id');
    }

    public static function findAllByAnnouncementId($id)
    {
        return self::where('ann_id',$id)->orderBy('dept_id','DESC')->get();
    }

    public static function findAllByAnnouncementIdmembers($id)
    {
    	$depts = self::where('ann_id',$id)->orderBy('dept_id','DESC')->pluck('dept_id');
        $results = [];
        foreach ($depts as $dept) {
            $results[] = $dept;
        }
        return $results;
    }
}
