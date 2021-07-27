<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\PEA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PEAController extends Controller
{
    public function getPEAFiled(Request $request)
    {
        $param = [
            0,
            MyHelper::decrypt(Session::get('Employee_ID')),
            $request->forRating,
            $request->controlNo ? : 0,
            $request->employeeName,
            $request->position ? : 0
        ];

        // dd($param);
        $data = PEA::getPEAFiled($param);

        return datatables($data)->toJson();
    }

    public function insertPEA(Request $request)
    {
        $param = [
            $request -> EmpID ? : 0,
            MyHelper::decrypt(Session::get('Employee_ID')),
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];

        $insert = PEA::insertPEA($param);

        $num = $insert[0]->Q_RETURN;
        $msg = $insert[0]->Q_MSG;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;


    }
}
