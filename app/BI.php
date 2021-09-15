<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BI extends Model
{
    public static function getBIFiled($data)
    {
        return DB::select('sp_BI_Passed_Get ?,?,?,?,?,?,?', $data);
    }

    public static function getBI($data)
    {
        return DB::select('sp_BI_get ?,?', $data);
    }

    public static function insertBI($data)
    {
        return DB::select('sp_BI_insert ?,?,?,?,?,?' , $data);
    }

    public static function updateBI($data)
    {
        return DB::select('sp_BI_update ?,?,?,?,?,?,?' , $data);
    }

    public static function getBIApproval($data)
    {
        return DB::select('sp_BI_Approval_Get ?,?,?,?,?,?,?,?' , $data);
    }

    public static function approveBI($data)
    {
        return DB::select('sp_BI_Approved_Insert ?,?,?,?' , $data);
    }

}
