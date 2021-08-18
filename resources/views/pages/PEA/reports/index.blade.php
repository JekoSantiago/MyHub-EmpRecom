@extends('layouts.main')
@section('content')
@php use App\Helper\MyHelper; @endphp


<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Probationary Employee Assessment</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </div>
                <h4 class="page-title">Probationary Employee Assessment</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-11">
            <a href="{{ route('RPT_NR',['Employee_ID' => MyHelper::decrypt(Session::get('Employee_ID'))]) }}"><button type="button" class="btn btn-lg btn-outline-light" style="background-color: #2C8F4F;">Print Non-Regular Summary</button></a> &nbsp;
        </div>
    </div>
    <div class="row pt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tbl_pea_reports" class="table table-centered w-100 nowrap">
                        <thead>
                            <tr>
                                <th>Location</th>
                                <th>AC Full Name</th>
                                <th>AM Full Name</th>
                                <th>Count Failed Submit</th>
                                <th>Count Failed Assessment</th>
                                <th>Count Failed Attendance</th>
                                <th>Count Failed Attitude</th>
                                <th>Count AWOL</th>
                                <th>Count Resigned</th>
                                <th>Total Pass</th>
                                <th>Total Emp</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ URL::asset('assets/js/custom/PEA.js')}}"></script>
@endsection
