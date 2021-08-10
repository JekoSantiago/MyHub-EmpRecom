<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\NPA;
use App\PEA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NPAController extends Controller
{
    public static function getNPA(Request $request)
    {
        $param = [
            $request -> forApproval,
            MyHelper::decrypt(Session::get('Employee_ID')),
            $request -> employeeName,
            $request -> department,
            $request -> position,
            0,
            MyHelper::decrypt(Session::get('Employee_ID')),
        ];

        $data = NPA::getNPA($param);
        return datatables($data)->toJson();

    }

    public static function getNPARec($id)
    {
        $data['title'] = "NPA Form";
        $param = [
            $id
        ];
        $emp = NPA::getNPARec($param);
        $AppEnable = 1;
        $HRApproves = [
            ($emp[0]->CheckedAndReviewed1) ? 3 : 0,
            ($emp[0]->CheckedAndReviewed2) ? 2 : 0,
            ($emp[0]->CheckedAndReviewed3) ? 1: 0,
        ];

        if(MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {


            if(in_array(MyHelper::decrypt(Session::get('PositionLevel_ID')),$HRApproves))
            {
                $AppEnable = 0;
            }
        }
        else
        {
            if(MyHelper::decrypt(Session::get('PositionLevel_ID')) <= 1)
            {
                if($emp[0]->ApprovedBy != null)
                {
                    $AppEnable = 0;
                }
            }
            else
            {
                if($emp[0]->RecommendedBy != null)
                {
                    $AppEnable = 0;
                }
            }
        }

        $data['emp'] = $emp;
        $data['AppEnable'] = $AppEnable;

        return view('pages.NPA.forms.NPA_form', $data);
    }

    public function showPEA($id)
    {

        $data['title'] = 'Ratings';
        $emp = PEA::getPEAFiled2([$id]);
        $rating = PEA::getRatings([$id]);
        $comment = PEA::getMonthlyComment([$id]);

        $data['emp'] = $emp;
        $data['chapter'] = DB::select('sp_chapter_get');
        $data['factor'] = DB::select('sp_PEA_Factor_Get');
        $data['option'] = DB::select('sp_PEA_RatingOption_Get');
        $data['scale'] = DB::select('sp_PEA_RatingScale_Get');
        $data['rating'] = $rating;
        $data['comment'] = $comment;

        return view ('pages.NPA.modals.content.modal_pea', $data);
    }

    public function approveNPA(Request $request)
    {

        if(MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {
            $ApproveType = 2;
        }
        else
        {
            if(MyHelper::decrypt(Session::get('PositionLevel_ID')) <= 1)
            {
                $ApproveType = 3;
            }
            else
            {
                $ApproveType = 1;
            }
        }

        $param = [
            MyHelper::decrypt(Session::get('Employee_ID')),
            $request -> EmpID,
            $ApproveType
        ];

        $insert = NPA::approveNPA($param);
        $num = $insert[0]->Q_RETURN;
        $msg = $insert[0]->Q_MSG;

        $result = array('num' => $num, 'msg' => $msg);
        return $result;


    }

    public function batchApprovedNPA(Request $request)
    {

        if(MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {
            $ApproveType = 2;
        }
        else
        {
            if(MyHelper::decrypt(Session::get('PositionLevel_ID')) <= 1)
            {
                $ApproveType = 3;
            }
            else
            {
                $ApproveType = 1;
            }
        }

        $EmpIDs = $request->EmpIDs;
        $count = 0;
        foreach($EmpIDs as $empID)
        {

            $param = [
                MyHelper::decrypt(Session::get('Employee_ID')),
                $empID,
                $ApproveType
            ];

            $insert = NPA::approveNPA($param);

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
}
