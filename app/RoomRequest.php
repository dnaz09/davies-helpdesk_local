<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomRequest extends Model
{
    protected $table = 'room_requests';

    protected $fillable = [
        'dept_id', 'user_id', 'details', 'approval', 'approver', 'status', 'room', 'start_date', 'end_date', 'start_time', 'end_time', 'facilitator', 'att_no', 'setup'
    ];

    public function aprvr()
    {
        return $this->hasOne('App\User', 'id', 'approver');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public static function getMyRequest($id)
    {
        return self::where('user_id', $id)->orderBy('created_at', 'DESC')->get();
    }

    public static function findByRequest($room, $start_date)
    {
        $date = date('m/d/Y', strtotime($start_date));

        $results = self::where('room', $room)
            // ->where('start_date',$date)
            // ->orWhere('end_date',$date) 
            ->where('status', '<', 1)
            ->get();

        return $results;
    }

    public static function getOngoingRooms()
    {
        $date_now = date('m/d/Y');
        return self::where('start_date', $date_now)
            ->where('end_date', $date_now)
            ->where('status', 1)
            ->get();
    }

    public static function getAll()
    {
        return self::orderBy('id', 'DESC')->get();
    }
}
