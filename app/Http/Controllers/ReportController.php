<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ReportController extends Controller
{
    public function getNonRegReport()
    {
        $data = Report::getNonRegReport();

        return datatables($data)->toJson();

    }

    public function showRPTPEA(Request $request)
    {

        $rptID = env('RPT_PEA'); //25
        $rptParam = 'Filed_ID='. $request->Filed_ID;
        $create = Report::createRPTSession($rptID, $rptParam);
        $result = $create[0]->RETURN;

        if($result != null) :
            Redirect::to(env('RPT_URL') . '?ID=' . $result)->send();
        else :
	        abort(404);
        endif;
    }

    public function showRPTEP(Request $request)
    {

        // $rptParam = 'From=' . $from . '|' .'To='. $to . '|' . 'HRID=' . $this->mylibrary->decrypted($this->session->Emp_Id);

        $rptID = env('RPT_EP'); //22
        $rptParam = 'Filed_ID='.$request->Filed_ID;
        $create = Report::createRPTSession($rptID, $rptParam);
        $result = $create[0]->RETURN;

        if($result != -1) :
            Redirect::to(env('RPT_URL') . '?ID=' . $result)->send();
        else :
	        abort(404);
        endif;
    }

    public function showRPTNPA(Request $request)
    {

        // $rptParam = 'From=' . $from . '|' .'To='. $to . '|' . 'HRID=' . $this->mylibrary->decrypted($this->session->Emp_Id);

        $rptID = env('RPT_NPA'); //24
        $rptParam = 'Employee_ID='.$request->Employee_ID;
        $create = Report::createRPTSession($rptID, $rptParam);
        $result = $create[0]->RETURN;

        if($result != -1) :
            Redirect::to(env('RPT_URL') . '?ID=' . $result)->send();
        else :
	        abort(404);
        endif;
    }

    public function showRPTRL(Request $request)
    {

        // $rptParam = 'From=' . $from . '|' .'To='. $to . '|' . 'HRID=' . $this->mylibrary->decrypted($this->session->Emp_Id);

        $rptID = ($request->RATINGS >=90) ? env('RPT_RL') : env('RPT_NRP');
        $rptParam = ($request->RATINGS >=90) ? 'Filed_ID='. $request->Filed_ID : 'Employee_ID='.$request->Employee_ID;
        $create = Report::createRPTSession($rptID, $rptParam);
        $result = $create[0]->RETURN;

        // dd($rptID,$rptParam);
        if($result != -1) :
            Redirect::to(env('RPT_URL') . '?ID=' . $result)->send();
        else :
	        abort(404);
        endif;
    }

    public function showRPTNonReg(Request $request)
    {

        // $rptParam = 'From=' . $from . '|' .'To='. $to . '|' . 'HRID=' . $this->mylibrary->decrypted($this->session->Emp_Id);

        $rptID = env('RPT_NREG');
        $rptParam = '0';
        $create = Report::createRPTSession($rptID, $rptParam);
        $result = $create[0]->RETURN;

        if($result != -1) :
            Redirect::to(env('RPT_URL') . '?ID=' . $result)->send();
        else :
	        abort(404);
        endif;
    }

    public function showRPTBI(Request $request)
    {

        // $rptParam = 'From=' . $from . '|' .'To='. $to . '|' . 'HRID=' . $this->mylibrary->decrypted($this->session->Emp_Id);

        $rptID = env('RPT_BI'); //11
        $rptParam = 'Employee_ID='.$request->Employee_ID;
        $create = Report::createRPTSession($rptID, $rptParam);
        $result = $create[0]->RETURN;

        if($result != -1) :
            Redirect::to(env('RPT_URL') . '?ID=' . $result)->send();
        else :
	        abort(404);
        endif;
    }



}
