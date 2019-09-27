<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GatePassDetail extends Model
{
    protected $table = 'gate_pass_details';

    protected $fillable = [
        'gate_pass_id','item_no','item_qty','item_measure','description','remarks'
    ];

    public static function getByGatePassId($id)
    {
        return self::where('gate_pass_id', $id)->get();
    }

    public static function findByIdFirst($id)
    {
        return self::where('id', $id)->first();
        ;
    }
}
