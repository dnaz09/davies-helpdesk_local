<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';

    protected $fillble = [

        'subject',
        'message',
        'uploaded_by'
    ];

    public static function getLatest($id)
    {

        $anns = self::where('id', $id)->first();

        $files = AnnouncementFile::where('ann_id', $anns->id)->get();

        if (!empty($files)) {
            $anns->files = $files;
        } else {
            $anns->files = "";
        }

        return $anns;
    }

    public function uploader()
    {
        return $this->hasOne('App\User', 'id', 'uploaded_by');
    }

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'dept_id');
    }

    public static function byDept($id)
    {
        return self::where('dept_id', $id)->orderBy('created_at', 'DESC')->get();
    }

    public static function getAll()
    {
        return self::all();
    }

    public static function getByMyDept($id)
    {
        return self::select('announcements.id', 'announcements.subject', 'announcements.created_at')->join('announcement_members', 'announcement_members.ann_id', '=', 'announcements.id')
            ->where('announcement_members.dept_id', $id)->orderBy('announcements.created_at', 'DESC')->get();
    }
}
