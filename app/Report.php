<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    public static function getNonRegReport()
    {
        return DB::select('sp_PEA_ReportNotReg_Get');
    }
}
