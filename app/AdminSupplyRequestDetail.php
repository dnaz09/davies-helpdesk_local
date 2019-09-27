<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Response;

class AdminSupplyRequestDetail extends Model
{
    protected $table = 'admin_supply_request_details';

    protected $fillable = [
        'admin_supply_request_id', 'item', 'qty', 'status', 'measurement', 'qty_r', 'qty_a', 'received_by'
    ];

    public function req()
    {
        return $this->hasOne('App\AdminSupplyRequest', 'id', 'admin_supply_request_id');
    }

    public static function findByAdminRequestId($id)
    {
        return self::where('admin_supply_request_id', $id)->get();
    }

    public static function findById($id)
    {
        return self::where('id', $id)->where('status', 1)->get();;
    }

    public static function findByReqId($id)
    {
        return self::where('admin_supply_request_id', $id)->get();
    }

    public static function findByIdFirst($id)
    {
        return self::where('id', $id)->where('status', 1)->first();;
    }

    public static function getReports($date_from, $date_to)
    {
        $from = date('Y-m-d', strtotime($date_from));
        $to = date('Y-m-d', strtotime($date_to));
        $items = self::select('admin_supply_request_details.*')->join('admin_supply_requests', 'admin_supply_requests.id', '=', 'admin_supply_request_details.admin_supply_request_id')
            ->whereDate('admin_supply_requests.created_at', '>=', $from)
            ->whereDate('admin_supply_requests.created_at', '<=', $to)
            ->where('admin_supply_requests.manager_action', 1)
            ->where('admin_supply_request_details.status', 2)
            ->orderBy('id', 'ASC')
            ->get();
        return $items;
    }

    public static function getPendings($id)
    {
        $pendings = self::where('admin_supply_request_id', $id)->where('status', 1)->get();

        return $pendings;
    }
}
