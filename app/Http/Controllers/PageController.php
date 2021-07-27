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



}
