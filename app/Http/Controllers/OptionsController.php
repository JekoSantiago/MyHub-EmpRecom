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
        $param = [
            0,
            0,
            MyHelper::decrypt(Session::get('Employee_ID')),
            0,
            0,
            ''];

        // dd($param);
        $data =  PEA::getEmp($param);

        $output = '<option></option>';

        foreach($data as $emp) :
            $output .= '<option value="'. $emp->Employee_ID .'">'. $emp->FullName .'</option>';
        endforeach;

        echo $output;
    }

    public function getEmployeeDatatable()
    {
        if(MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        {
            $id = 0;
        }
        else
        {
           $id =  MyHelper::decrypt(Session::get('Employee_ID'));
        }

        $param = [
            0,
            0,
            $id,
            0,
            0,
            ''];

        // dd($param);
        $data =  PEA::getEmp($param);

        return datatables($data)->toJson();


    }

    public function getLocation()
    {
        $data = Common::getLocation();

        $output = '<option></option>';

        foreach($data as $loc) :
            $output .= '<option value="'. $loc->Location_ID .'">'. $loc->Location .'</option>';
        endforeach;

        echo $output;
    }

    public function getDepartment()
    {
        $data = Common::getDepartment();

        $output = '<option></option>';

        foreach($data as $dept) :
            $output .= '<option value="'. $dept->Department_ID .'">'. $dept->Department .'</option>';
        endforeach;

        echo $output;
    }


}
