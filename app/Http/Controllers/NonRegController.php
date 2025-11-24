<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\NonReg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NonRegController extends Controller
{

    public function getNonRegApp(Request $request)
    {
        $param = [
            $request -> forApproval,
            $request -> employeeName ? : '',
            $request -> department ? : 0,
            $request -> position ? : 0,
            0,
            0
        ];

        $data = NonReg::getNonReg($param);

        return datatables($data)->toJson();

    }

    public function batchApprovedFile(Request $request)
    {


        $EmpIDs = $request->EmployeeID;
        $count = 0;
        foreach($EmpIDs as $empID)
        {

            $param = [
                $empID,
                1,
                $request -> Remarks ? : '',
                MyHelper::decrypt(Session::get('Employee_ID')),
            ];

            $insert = NonReg::approveNonReg($param);

            if($insert[0]->RETURN > 0)
            {
                $count++;
            }

        }

        $num = $count;
        $msg = "Successfully approved " . $count . " employees.";

        $result = array('num' => $num, 'msg' => $msg);
        return $result;

    }
}
