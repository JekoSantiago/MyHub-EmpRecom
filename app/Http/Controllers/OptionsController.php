<?php

namespace App\Http\Controllers;

use App\Common;
use App\Helper\MyHelper;
use App\Location;
use App\PEA;
use App\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OptionsController extends Controller
{
    public function getPosition()
    {
        $data = Common::getPosition();

        $output = '<option></option>';

        foreach($data as $pos) :
            $output .= '<option value="'. $pos->DeptPosition_ID .'">'. $pos->PositionName .'</option>';
        endforeach;

        echo $output;
    }

    public function getEmployeePEA()
    {
        $param = [0,0,MyHelper::decrypt(Session::get('Employee_ID')),0,5,''];

        $data =  PEA::getEmp($param);

        $output = '<option></option>';

        foreach($data as $emp) :
            $output .= '<option value="'. $emp->Employee_ID .'">'. $emp->FullName .'</option>';
        endforeach;

        echo $output;
    }


}