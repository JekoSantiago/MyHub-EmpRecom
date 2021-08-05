<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NonReg extends Model
{
    public static function getNonReg($data)
    {
        return DB::select('sp_NonRegLetter_Approval_Get ?,?,?,?,?', $data);
    }

    public static function approveNonReg($data)
    {
        return DB::select('sp_NonRegLetter_Approved_Insert ?,?,?,?', $data);
    }
}
