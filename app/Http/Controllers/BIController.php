<?php

namespace App\Http\Controllers;

use App\BI;
use App\Helper\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BIController extends Controller
{
    public function getBIFiled(Request $request)
    {
        $param = [
            0,
            MyHelper::decrypt(Session::get('Employee_ID')),
            $request->employeeName,
            $request->position ? : 0,
            $request->fdatestart ? : '',
            $request->fdateend ? : '',
            $request->withBI
        ];
        // dd($param);
        $data = BI::getBIFiled($param);

        return datatables($data)->toJson();
    }

    public function fileBI($id)
    {
        $data['title'] = 'BI Form';
        $param = [
            0,
            $id
        ];

        $emp = BI::getBI($param);
        $data['emp']=$emp;

        return view('pages.BI.filing.index',$data);

    }

    public function insertBI(Request $request)
    {
        $param = [
            $request -> employeeID,
            $request -> summary ? : '',
            $request -> charref ? : '',
            $request -> comref ? : '',
            $request -> educref ? : '',
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];

        $insert = BI::insertBI($param);

        $num = $insert[0]->Q_RETURN;
        $msg = $insert[0]->Q_MSG;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;


    }

    public function updateBI(Request $request)
    {
        $param = [
            $request -> BI_ID,
            $request -> employeeID,
            $request -> summary ? : '',
            $request -> charref ? : '',
            $request -> comref ? : '',
            $request -> educref ? : '',
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];

        $update = BI::updateBI($param);

        $num = $update[0]->Q_RETURN;
        $msg = $update[0]->Q_MSG;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;
    }

    public function getBIApp(Request $request)
    {
        $param = [
            $request -> appStatus,
            $request->employeeName,
            $request->position ? : 0,
            $request->type,
            $request->fdatestart ? : '',
            $request->fdateend ? : '',
            MyHelper::decrypt(Session::get('Employee_ID')),
        ];

        // dd($param);
        $data = BI::getBIApproval($param);

        return datatables($data)->toJson();
    }

    public function approveBI(Request $request)
    {
        $param = [
            $request -> BI_ID,
            $request -> employeeID,
            1,
            MyHelper::decrypt(Session::get('Employee_ID')),
        ];

        $insert = BI::approveBI($param);

        $num = $insert[0]->Q_RETURN;
        $msg = $insert[0]->Q_MSG;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;
    }
}
