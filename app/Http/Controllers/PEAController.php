<?php

namespace App\Http\Controllers;

use App\BI;
use App\Common;
use App\Helper\MyHelper;
use App\NonReg;
use App\NPA;
use App\PEA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

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

    public function getPEAApproved(Request $request)
    {
        $param = [
            0,
            MyHelper::decrypt(Session::get('Employee_ID')),
            $request->forApproval ? : 0,
            $request->controlNo ? : null,
            $request->position ? : 0,
            $request->location ? : 0,
            $request->employeeName ? : null,
            $request->fdatestart ? : '1900-01-01',
            $request->fdateend ? : '1900-01-01',
            $request->hdatestart ? : '1900-01-01',
            $request->hdateend ? : '1900-01-01'

        ];

        // dd($param);

        $data = PEA::getPEAApproval($param);
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

        $userID = MyHelper::decrypt(Session::get('Employee_ID'));

        $param = [
            $id,
            $userID,
            0,
            0,
            '',
            0
        ];
        $data['title'] = 'Ratings';
        $emp = PEA::getPEAFiled2($param);
        $empID = $emp[0]->Employee_ID;
        $rating = PEA::getRatings([$id]);
        $bi = BI::getBIApproval([1,'',0,0,'','',0,$empID]);
        $nr = NonReg::getNonReg([1,'',0,0,0,$empID]);
        $showNPA = 0;
        $npaEmp =[];

        if(MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {
            $npa = NPA::getNPA([1,$userID,'','','',0,0,$empID]);

            foreach($npa as $empNPA)
            {
                if($empNPA->DateRecommended != null)
                {
                    array_push($npaEmp,$empNPA->Employee_ID);
                }
            }
            $showNPA = in_array($emp[0]->Employee_ID,$npaEmp) ? 1 : 0;

            $data['npa'] = $npa;
        }
        $biEmp = [];
        $nrEmp = [];

        foreach($bi as $empBI)
        {
            if($empBI->BI_Approved = 1)
            {
                array_push($biEmp,$empBI->EmployeeID);
            }
        }
        foreach($nr as $empNR)
        {
            array_push($nrEmp,$empNR->Employee_ID);
        }
        $showBI = in_array($emp[0]->Employee_ID,$biEmp) ? 1 : 0;
        if($emp[0]->TotalPoint >= 90)
        {
            $showNR = ($emp[0]->ExecAppDate != null) ? 1 : 0;
        }
        else
        {
            $showNR = in_array($emp[0]->Employee_ID,$nrEmp) ? 1 : 0;
        }

        $data['emp'] = $emp;
        $data['chapter'] = DB::select('sp_chapter_get');
        $data['factor'] = DB::select('sp_PEA_Factor_Get');
        $data['option'] = DB::select('sp_PEA_RatingOption_Get');
        $data['scale'] = DB::select('sp_PEA_RatingScale_Get');
        $data['rating'] = $rating;
        $data['showBI'] = $showBI;
        $data['showNR'] = $showNR;
        $data['showNPA'] = $showNPA;


        // dd($nrEmp);
        $isHRRated = (intval($emp[0]->HRRateStatus));
        $isHR = (MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID')) ? 1:0;
        $isDisApp = (intval($emp[0]->isdisApproved) ? : 0) ;
        $isApproved = (intval($emp[0]->AMAppDate) ? 1 : 0) ;
        $isAccepted = (intval($emp[0]->EmpAccDate) ? 1 : 0) ;

        $Qremain = $emp[0]->NumOfQuestRemain;

        $ApproveType = 0;
        if (MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {
            $ApproveType = 2;
        }
        else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) == 3 )
        {
            $ApproveType = 1;
        }
        else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) <= 2)
        {
            $ApproveType = 3;
        }

        // dd($ApproveType);

        JavaScriptFacade::put([
            'isHR' =>  $isHR,
            'isHRRated' => $isHRRated,
            'ApproveType' => $ApproveType,
            'Qremain' => intval($Qremain),
            'isDisApp' => $isDisApp,
            'isApproved' => $isApproved,
            'isAccepted' => $isAccepted
        ]);

        return view ('pages.PEA.ratings.index', $data);
    }

    public function insertRatings(Request $request)
    {

        $month1 = 'M1_' . $request -> FactorID;
        $month2 = 'M2_' . $request -> FactorID;
        $month3 = 'M3_' . $request -> FactorID;

        $param = [
            $request -> FiledID,
            $request -> FactorID,
            $request -> $month1,
            $request -> $month2,
            $request -> $month3,
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];

        $insert = PEA::insertRatings($param);
        $refresh = PEA::refreshRatings([$request -> FiledID]);

        $num = $insert[0]->Q_RETURN;
        $msg = $insert[0]->Q_MSG;
        $ave = $refresh[0]->PerFactorTotal;
        $qremain = $refresh[0]->QRemain;

        $result = array('num' => $num, 'msg' => $msg, 'ave' => $ave, 'qremain' =>  $qremain);
        return $result;
    }

    public function updateRatings(Request $request)
    {
        $month1 = 'M1_' . $request -> FactorID;
        $month2 = 'M2_' . $request -> FactorID;
        $month3 = 'M3_' . $request -> FactorID;

        $param = [
            $request -> FiledID,
            $request -> FactorID,
            $request -> $month1,
            $request -> $month2,
            $request -> $month3,
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];

        $update = PEA::updateRatings($param);
        $refresh = PEA::refreshRatings([$request -> FiledID]);

        $num = $update[0]->Q_RETURN;
        $msg = $update[0]->Q_MSG;
        $ave = $refresh[0]->PerFactorTotal;
        $qremain = $refresh[0]->QRemain;

        $result = array('num' => $num, 'msg' => $msg, 'ave' => $ave, 'qremain' =>  $qremain);
        return $result;
    }

    public function monthlyComments($id)
    {
        // dd($request);
        $param = [
            $id
        ];


        $data = PEA::getMonthlyComment($param);

        return datatables($data)->toJson();

    }

    public function insertMonthlyComments(Request $request)
    {
        $ApproveType = 1;

        $param = [
            $request->FiledID,
            $request->MonthID,
            MyHelper::decrypt(Session::get('Employee_ID')),
            $ApproveType,
            $request->monthly_comment,
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];
        // dd($param);

        $insert = PEA::insertMonthlyComment($param);

        $num = $insert[0]->Q_RETURN;
        $msg = $insert[0]->Q_MSG;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;
    }

    public function updateMonthlyComments(Request $request)
    {
        $ApproveType = 1;
        $param = [
            $request->CommentID,
            $request->FiledID,
            $request->MonthID,
            MyHelper::decrypt(Session::get('Employee_ID')),
            $ApproveType,
            $request->monthly_comment,
            MyHelper::decrypt(Session::get('Employee_ID'))
        ];
        // dd($param);

        $insert = PEA::updateMonthlyComment($param);

        $num = $insert[0]->Q_RETURN;
        $msg = $insert[0]->Q_MSG;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;
    }

    public function updateRecomLetter(Request $request)
    {
        $param = [
            $request -> FiledIDRec,
            $request -> recom_letter,
            $request -> PRA,
            $request -> SnE,
            $request -> SAR
        ];

        $update = PEA::updateRecomLetter($param);

        $num = $update[0]->Q_RETURN;
        $msg = $update[0]->Q_MSG;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;

    }

    public function insertApprovedFile(Request $request)
    {

        if($request -> Type == 1)
        {
            if (MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
            {
                $ApproveType = 2;
            }
            else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) == 3)
            {
                $ApproveType = 1;
            }
            else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) <= 2)
            {
                $ApproveType = 3;
            }
        }
        else
        {
            $ApproveType = 0;
        }

        $param = [
            $request -> FiledID,
            MyHelper::decrypt(Session::get('Employee_ID')),
            $ApproveType,
            $request -> remarks ? : '',
            MyHelper::decrypt(Session::get('Employee_ID')),
        ];

        $insert = PEA::insertApprovedFile($param);

        $num = $insert[0]->Q_RETURN;
        $msg = $insert[0]->Q_MSG;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;

    }

    public function batchApprovedFile(Request $request)
    {

        if (MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {
            $ApproveType = 2;
        }
        else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) == 3)
        {
            $ApproveType = 1;
        }
        else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) <= 2)
        {
            $ApproveType = 3;
        }


        $FiledIDs = $request->FiledID;
        $count = 0;
        foreach($FiledIDs as $FiledID)
        {

            $param = [
                $FiledID,
                MyHelper::decrypt(Session::get('Employee_ID')),
                $ApproveType,
                $request -> Remarks ? : '',
                MyHelper::decrypt(Session::get('Employee_ID')),
            ];

            $insert = PEA::insertApprovedFile($param);

            if($insert[0]->Q_RETURN > 0)
            {
                $count++;
            }

        }

        $num = $count;
        $msg = "Successfully approved " . $count . " employees.";

        $result = array('num' => $num, 'msg' => $msg);
        return $result;

    }

    public function disApproveFile(Request $request)
    {
        $param = [
            $request -> FiledID,
            $request -> remarks
        ];

        $insert = PEA::disApproveFile($param);

        $num = $insert[0]->Q_RETURN;
        $msg = $insert[0]->Q_MSG;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;

    }



}
