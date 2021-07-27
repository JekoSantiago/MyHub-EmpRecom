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

    public static function getEmp($data)
    {
        return DB::select('sp_Emp_get ?,?,?,?,?,?' , $data);
    }

    public static function insertPEA($data)
    {
        return DB::select('sp_PEA_Filed_Insert ?,?,?' , $data);
    }
}
