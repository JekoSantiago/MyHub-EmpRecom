<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PEA extends Model
{
    public static function getPEAFiled($data)
    {
        return DB::select('sp_PEA_Filed_Get ?,?,?,?,?,?' , $data);
    }

    public static function getPEAFiled2($data)
    {
        return DB::select('sp_PEA_Filed_Get ?' , $data);
    }

    public static function getEmp($data)
    {
        return DB::select('sp_Emp_get ?,?,?,?,?,?' , $data);
    }

    public static function insertPEA($data)
    {
        return DB::select('sp_PEA_Filed_Insert ?,?,?' , $data);
    }

    public static function updatePEA($data)
    {
        return DB::select('sp_PEA_Filed_Update ?,?,?,?', $data);
    }

    public static function getRatings($data)
    {
        return DB::select('sp_PEA_EmpRate_Get ?', $data);
    }

    public static function insertRatings($data)
    {
        return DB::select('sp_PEA_EmpRate_Insert ?,?,?,?,?,?' , $data);
    }

    public static function updateRatings($data)
    {
        return DB::select('sp_PEA_EmpRate_Update ?,?,?,?,?,?' , $data);
    }

    public static function refreshRatings($data)
    {
        return DB::select('sp_PEA_Rating_Refresh_Get ?' , $data);
    }

    public static function getMonthlyComment($data)
    {
        return DB::select('sp_PEA_MonthlyApproved_Get ?' , $data);
    }

    public static function insertMonthlyComment($data)
    {
        return DB::select('sp_PEA_MonthlyApproved_Insert ?,?,?,?,?,?' , $data);
    }

    public static function updateMonthlyComment($data)
    {
        return DB::select('sp_PEA_MonthlyApproved_Update ?,?,?,?,?,?,?' , $data);
    }

    public static function updateRecomLetter($data)
    {
        return DB::select('sp_PEA_RecomLetter_Update ?,?,?,?,?' , $data);
    }

    public static function getRecomLetter($data)
    {
        return DB::select('sp_PEA_RecomLetter_Get ?' , $data);
    }

    public static function getPEAApproval($data)
    {
        return DB::select('sp_PEA_FiledApproved_Get ?,?,?,?,?,?,?,?,?,?,?' , $data);
    }

    public static function insertApprovedFile($data)
    {
        return DB::select('sp_PEA_Approved_Insert ?,?,?,?,?', $data);
    }

    public static function disApproveFile($data)
    {
        return DB::select('sp_PEA_Disapproved_Update ?,?' , $data);
    }
}
