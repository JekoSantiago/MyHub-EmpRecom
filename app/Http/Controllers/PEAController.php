<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
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
        // dd($data);

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
        $emp = PEA::getPEAFiled2($param);
        $rating = PEA::getRatings([$id]);
        $comment = PEA::getMonthlyComment([$id]);
        $recom = PEA::getRecomLetter([$id]);

        $data['emp'] = $emp;
        $data['chapter'] = DB::select('sp_chapter_get');
        $data['factor'] = DB::select('sp_PEA_Factor_Get');
        $data['option'] = DB::select('sp_PEA_RatingOption_Get');
        $data['scale'] = DB::select('sp_PEA_RatingScale_Get');
        $data['rating'] = $rating;

        // dd($emp);
        $isHRRated = (intval($emp[0]->HRRateStatus));
        $isHR = (MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID')) ? 1:0;
        $countCom = 0;
        foreach ($comment as $com)
        {
            if (is_null($com->EvalComment) == false)
            {
                $countCom++;
            }
        }

        JavaScriptFacade::put([
            'isHR' =>  $isHR,
            'isHRRated' => $isHRRated,
            'isCommented' => $countCom
        ]);

        return view ('pages.PEA.in-process.ratings.index', $data);
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

        $result = array('num' => $num, 'msg' => $msg, 'ave' => $ave);
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

        $result = array('num' => $num, 'msg' => $msg, 'ave' => $ave);
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

        if (MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {
            $ApproveType = 2;
        }
        else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) == env('1'))
        {
            $ApproveType = 3;
        }

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

        if (MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {
            $ApproveType = 2;
        }
        else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) == 1)
        {
            $ApproveType = 3;
        }
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



}
