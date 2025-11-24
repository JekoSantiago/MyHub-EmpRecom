<?php

namespace App\Http\Controllers;

use App\Common;
use App\Helper\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class PageController extends Controller
{

    public function viewHome()
    {
        $data['title'] = "Home";
        return view('pages.home.index',$data);

    }

    public function PEAinProcess(Request $request)
    {

        if (MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {
            $ApproveType = 2;
        }
        else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) == 3)
        {
            $ApproveType = 1;
        }
        else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) == 1 || MyHelper::decrypt(Session::get('PositionLevel_ID')) == 2)
        {
            $ApproveType = 3;
        }
        else{ $ApproveType = 0;}

        $data['title'] ="PEA Filed";
        $isHR = (MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID')) ? 1:0;
        JavaScriptFacade::put([
            'isHR' =>  $isHR,
            'ApproveType' =>  $ApproveType
        ]);
        $paramPEAFiled['forRating']         =  $request->input('forRating') ? : 0;
        $paramPEAFiled['controlNo']         =  $request->input('controlNo') ? : '';
        $paramPEAFiled['employeeName']      =  $request->input('employeeName') ? : '';
        $paramPEAFiled['position']          =  $request->input('position') ? : 0;
        $data['paramPEAFiled']              = $paramPEAFiled;

        return view('pages.PEA.in-process.index',$data);

    }

    public function PEAapproval(Request $request)
    {

        if (MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {
            $ApproveType = 2;
        }
        else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) == 3)
        {
            $ApproveType = 1;
        }
        else if(MyHelper::decrypt(Session::get('PositionLevel_ID')) == 1 || MyHelper::decrypt(Session::get('PositionLevel_ID')) == 2)
        {
            $ApproveType = 3;
        }
        else{ $ApproveType = 0;}

        $data['title'] ="PEA Approval";

        $paramPEAApproval['forApproval']      =  $request->input('forApproval') ? : 0;
        $paramPEAApproval['controlNo']        =  $request->input('controlNo') ? : '';
        $paramPEAApproval['employeeName']     =  $request->input('employeeName') ? : '';
        $paramPEAApproval['position']         =  $request->input('position') ? : 0;
        $paramPEAApproval['location']         =  $request->input('location') ? : 0;
        $paramPEAApproval['fdatestart']       =  $request->input('fdatestart') ? : '';
        $paramPEAApproval['fdateend']         =  $request->input('fdateend') ? : '';
        $paramPEAApproval['hdatestart']       =  $request->input('hdatestart') ? : '';
        $paramPEAApproval['hdateend']         =  $request->input('hdateend') ? : '';
        JavaScriptFacade::put([
            'ApproveType' =>  $ApproveType
        ]);

        $data['paramPEAApproval']    = $paramPEAApproval;

        return view('pages.PEA.approval.index',$data);
    }

    public function PEAReports()
    {
        $data['title'] = "PEA Report";
        return view ('pages.PEA.reports.index',$data);
    }

    public function BIinProcess(Request $request)
    {

        $data['title'] ="BI Filed";
        $paramBI['withBI']              =  $request->input('withBI') ? : 2;
        $paramBI['employeeName']        =  $request->input('employeeName') ? : '';
        $paramBI['position']            =  $request->input('position') ? : 0;
        $paramBI['fdatestart']          =  $request->input('fdatestart') ? : '';
        $paramBI['fdateend']            =  $request->input('fdateend') ? : '';
        $data['paramBI']                = $paramBI;

        return view('pages.BI.in-process.index',$data);
    }


    public function BIApproval(Request $request)
    {

        $data['title'] ="BI Approval";
        $paramBI['appStatus']           =  $request->input('appStatus') ? : 2;
        $paramBI['type']                =  $request->input('type') ? : 0;
        $paramBI['employeeName']        =  $request->input('employeeName') ? : '';
        $paramBI['position']            =  $request->input('position') ? : 0;
        $paramBI['fdatestart']          =  $request->input('fdatestart') ? : '';
        $paramBI['fdateend']            =  $request->input('fdateend') ? : '';
        $data['paramBI']                = $paramBI;

        return view('pages.BI.approval.index',$data);

    }

    public function NonReg(Request $request)
    {

        $data['title'] ="Non-Regular Approval";
        $paramNonReg['forApproval']              =  $request->input('forApproval') ? : 2;
        $paramNonReg['employeeName']             =  $request->input('employeeName') ? : '';
        $paramNonReg['position']                 =  $request->input('position') ? : 0;
        $paramNonReg['department']               =  $request->input('department') ? : 0;
        $data['paramNonReg']                     = $paramNonReg;

        return view('pages.NonReg.index',$data);

    }

    public function NPA(Request $request)
    {
        $BatchApproval = 0;
        if(MyHelper::decrypt(Session::get('PositionLevel_ID')) <= 2 || MyHelper::decrypt(Session::get('Employee_ID'))==4056)
        {
            $BatchApproval = 1;
        }

        JavaScriptFacade::put([
            'BatchApproval' =>  $BatchApproval
        ]);

        $data['title'] ="NPA Approval";
        $paramNPA['forApproval']              =  $request->input('forApproval') ? : 2;
        $paramNPA['employeeName']             =  $request->input('employeeName') ? : '';
        $paramNPA['position']                 =  $request->input('position') ? : 0;
        $paramNPA['department']               =  $request->input('department') ? : 0;
        $data['paramNPA']                     = $paramNPA;

        return view('pages.NPA.index',$data);
    }

    public function Probi()
    {
        $data['title'] = "List of Probationary";
        return view('pages.Probi.index', $data);
    }

    public function PEAAccept(Request $request)
    {
        $data['title'] = "PEA Acceptance";
        $ApproveType = 4;
        JavaScriptFacade::put([
            'ApproveType' =>  $ApproveType
        ]);
        $paramPEAAccept['forRating']         =  $request->input('forRating') ? : 0;
        $paramPEAAccept['controlNo']         =  $request->input('controlNo') ? : '';
        $paramPEAAccept['employeeName']      =  $request->input('employeeName') ? : '';
        $paramPEAAccept['position']          =  $request->input('position') ? : 0;
        $data['paramPEAAccept']                 = $paramPEAAccept;

        return view('pages.Accept.pea.index', $data);
    }

    public function NPAAccept(Request $request)
    {
        $data['title'] = "NPA Acceptance";
        $paramNPAAccept['forRating']              =  $request->input('forRating') ? : 2;
        $paramNPAAccept['employeeName']             =  $request->input('employeeName') ? : '';
        $paramNPAAccept['position']                 =  $request->input('position') ? : 0;
        $data['paramNPAAccept']                     = $paramNPAAccept;

        return view('pages.Accept.npa.index', $data);
    }

    public function NonRegAccept(Request $request)
    {
        $data['title'] = "Non Reg Acceptance";

        $paramNonRegAccept['forRating']              =  $request->input('forRating') ? : 2;
        $paramNonRegAccept['employeeName']             =  $request->input('employeeName') ? : '';
        $paramNonRegAccept['position']                 =  $request->input('position') ? : 0;
        $data['paramNonRegAccept']                     = $paramNonRegAccept;

        return view('pages.Accept.nonreg.index', $data);
    }



}
