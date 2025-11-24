<?php

namespace App\Http\Controllers;

use App\Acceptance;
use App\Common;
use App\Helper\MyHelper;
use App\NPA;
use App\PEA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AcceptanceController extends Controller
{
    public function getPEAAcceptance(Request $request)
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
        $data = Acceptance::getPEAAcceptance($param);

        return datatables($data)->toJson();
    }


    public function showPEA($id)
    {
        $data['title'] = 'Ratings';
        $userID = MyHelper::decrypt(Session::get('Employee_ID'));
        $emp = PEA::getPEAFiled2([$id,$userID]);
        $rating = PEA::getRatings([$id]);
        $comment = PEA::getMonthlyComment([$id]);
        $data['emp'] = $emp;
        $data['chapter'] = DB::select('sp_chapter_get');
        $data['factor'] = DB::select('sp_PEA_Factor_Get');
        $data['option'] = DB::select('sp_PEA_RatingOption_Get');
        $data['scale'] = DB::select('sp_PEA_RatingScale_Get');
        $data['rating'] = $rating;
        $data['comment'] = $comment;

        return view ('pages.Accept.pea.modals.content.modal_pea', $data);

    }

    public function insertApprovedFile(Request $request)
    {

        $ApproveType = 4;

        $param = [
            $request -> FiledID,
            $request -> empID,
            $ApproveType,
            'Accepted',
            MyHelper::decrypt(Session::get('Employee_ID')),
        ];

        $insert = PEA::insertApprovedFile($param);

        $num = $insert[0]->Q_RETURN;
        $msg = 'Successfully Accepted';

        $result = array('num' => $num, 'msg' => $msg);
        return $result;

    }

    public function getEmpPIN(Request $request)
    {
        $userID =  $request->empID;
        $empNo = $request->empNo;
        $res = Common::getUserPIN([$userID]);
        $pin = $res[0]->PIN;

        $rqPIN = $request -> PIN;

        $vPIN = MyHelper::passwordEncrypt($empNo,$rqPIN);

        if($vPIN == $pin)
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }

    public function getNPAAcceptance(Request $request)
    {
        $param = [
            $request -> forRating,
            $request -> employeeName,
            $request -> position ? : 0,
            MyHelper::decrypt(Session::get('Employee_ID')),
        ];

        $data = Acceptance::getNPAAcceptance($param);
        return datatables($data)->toJson();
    }

    public static function showNPA($id)
    {
        $data['title'] = "NPA Form";
        $param = [
            $id
        ];
        $emp = NPA::getNPARec($param);
        // dd($emp);
        $AppEnable = ($emp[0]->AcceptedBy == NULL) ? 1 : 0;
        $data['emp'] = $emp;
        $data['AppEnable'] = $AppEnable;
        return view('pages.Accept.npa.modals.content.modal_npa', $data);
    }

    public function acceptNPA(Request $request)
    {
        $param = [
            MyHelper::decrypt(Session::get('Employee_ID')),
            $request -> empID,
            4
        ];
        $insert = NPA::approveNPA($param);
        $num = $insert[0]->Q_RETURN;
        $msg = 'Successfully Accepted';
        $result = array('num' => $num, 'msg' => $msg);
        return $result;
    }

    public function getNonRegAcceptance(Request $request)
    {
        $param = [
            $request -> forRating,
            $request -> employeeName,
            $request -> position ? : 0,
            MyHelper::decrypt(Session::get('Employee_ID')),
        ];
        $data = Acceptance::getNonRegAcceptance($param);
        return datatables($data)->toJson();
    }

    public function acceptNonReg(Request $request)
    {
        $param = [
            $request -> NonRegID,
            2,
            'Accepted',
            MyHelper::decrypt(Session::get('Employee_ID')),
        ];
        $insert = Acceptance::updateNonRegLetter($param);
        $num = $insert[0]->RETURN;
        $msg = 'Successfully Accepted';
        $result = array('num' => $num, 'msg' => $msg);
        return $result;
    }
}
