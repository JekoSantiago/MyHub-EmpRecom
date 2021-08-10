<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getNonRegReport()
    {
        $data = Report::getNonRegReport();

        return datatables($data)->toJson();

    }
}
