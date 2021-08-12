<?php

namespace App;

use App\Helper\MyHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Report extends Model
{
    public static function getNonRegReport()
    {
        return DB::select('sp_PEA_ReportNotReg_Get');
    }

    public static function createRPTSession($reportID, $reportParam)
    {
        $empID = MyHelper::decrypt(Session::get('Employee_ID'));

        $result = DB::connection('dbRptSession')->select('EXEC [sp_RptSession_Create] ?, ?, ?', [$empID, $reportID, $reportParam]);
        return $result;
    }
}
