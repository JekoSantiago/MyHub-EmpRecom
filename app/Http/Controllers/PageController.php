<?php

namespace App\Http\Controllers;

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
        $data['title'] ="PEA Filed";

        $paramPEAFiled['forRating']      =  $request->input('forRating') ? : 0;
        $paramPEAFiled['controlNo']        =  $request->input('controlNo') ? : '';
        $paramPEAFiled['employeeName']        =  $request->input('employeeName') ? : '';
        $paramPEAFiled['position']        =  $request->input('position') ? : 0;
        $data['paramPEAFiled']    = $paramPEAFiled;


        return view('pages.PEA.in-process.index',$data);
    }

    public function PEAapproval(Request $request)
    {
        $data['title'] ="PEA Approval";

        $paramPEAApproval['forApproval']      =  $request->input('forApproval') ? : 0;
        $paramPEAApproval['controlNo']        =  $request->input('controlNo') ? : '';
        $paramPEAApproval['employeeName']        =  $request->input('employeeName') ? : '';
        $paramPEAApproval['position']        =  $request->input('position') ? : 0;
        $paramPEAApproval['location']        =  $request->input('location') ? : 0;
        $paramPEAApproval['fdatestart']        =  $request->input('fdatestart') ? : '';
        $paramPEAApproval['fdateend']        =  $request->input('fdateend') ? : '';
        $paramPEAApproval['hdatestart']        =  $request->input('hdatestart') ? : '';
        $paramPEAApproval['hdateend']        =  $request->input('hdateend') ? : '';

        $data['paramPEAApproval']    = $paramPEAApproval;
        return view('pages.PEA.approval.index',$data);
    }



}
