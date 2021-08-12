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

    public function showRPTPEA()
    {

        // $rptParam = 'From=' . $from . '|' .'To='. $to . '|' . 'HRID=' . $this->mylibrary->decrypted($this->session->Emp_Id);

        $rptID = env('RPT_PEA');
        $rptParam = '';
        $create = Report::createRPTSession($rptID, $rptParam);
        $result = $create[0]->RETURN;

        if($result > 1) :
            Redirect::to(env('RPT_URL') . '?ID=' . $result)->send();
        else :
	        abort(404);
        endif;
    }

    public function showRPTEP()
    {

        // $rptParam = 'From=' . $from . '|' .'To='. $to . '|' . 'HRID=' . $this->mylibrary->decrypted($this->session->Emp_Id);

        $rptID = env('RPT_EP');
        $rptParam = '';
        $create = Report::createRPTSession($rptID, $rptParam);
        $result = $create[0]->RETURN;

        if($result > 1) :
            Redirect::to(env('RPT_URL') . '?ID=' . $result)->send();
        else :
	        abort(404);
        endif;
    }

    public function showRPTRL()
    {

        // $rptParam = 'From=' . $from . '|' .'To='. $to . '|' . 'HRID=' . $this->mylibrary->decrypted($this->session->Emp_Id);

        $rptID = env('RPT_RL');
        $rptParam = '';
        $create = Report::createRPTSession($rptID, $rptParam);
        $result = $create[0]->RETURN;

        if($result > 1) :
            Redirect::to(env('RPT_URL') . '?ID=' . $result)->send();
        else :
	        abort(404);
        endif;
    }

    public function showRPTNonReg()
    {

        // $rptParam = 'From=' . $from . '|' .'To='. $to . '|' . 'HRID=' . $this->mylibrary->decrypted($this->session->Emp_Id);

        $rptID = env('RPT_NREG');
        $rptParam = '';
        $create = Report::createRPTSession($rptID, $rptParam);
        $result = $create[0]->RETURN;

        if($result > 1) :
            Redirect::to(env('RPT_URL') . '?ID=' . $result)->send();
        else :
	        abort(404);
        endif;
    }
}
