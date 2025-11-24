<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NPA extends Model
{
    public static function getNPA($data)
    {
        return DB::select('sp_NPA_get ?,?,?,?,?,?,?,?', $data);
    }

    public static function getNPARec($data)
    {
        return DB::select('sp_NPA_Rec_get ?', $data);
    }

    public static function approveNPA($data)
    {
        return DB::select('sp_NPA_Approved_insert ?,?,?' , $data);
    }
}
