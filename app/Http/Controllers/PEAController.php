<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\PEA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function updatePEA(Request $request)
    {
        $param = [
            $request -> FiledID,
            $request -> EmpID ? : 0,
            MyHelper::decrypt(Session::get('Employee_ID')),
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];

        $update = PEA::updatePEA($param);

        $num = $update[0]->Q_RETURN;
        $msg = $update[0]->Q_MSG;


        $result = array('num' => $num, 'msg' => $msg);
        return $result;
    }

    public function ratePEA($id)
    {
        $param = [
            $id,
            MyHelper::decrypt(Session::get('Employee_ID')),
            0,
            0,
            '',
            0
        ];
        $data['title'] = 'Ratings';
        $emp = PEA::getPEAFiled($param);

        $data['emp'] = $emp;
        $data['chapter'] = DB::select('sp_chapter_get');
        $data['factor'] = DB::select('sp_PEA_Factor_Get');
        $data['option'] = DB::select('sp_PEA_RatingOption_Get');
        $data['scale'] = DB::select('sp_PEA_RatingScale_Get');
        // dd($data);
        return view ('pages.PEA.in-process.ratings.index', $data);
    }
}
