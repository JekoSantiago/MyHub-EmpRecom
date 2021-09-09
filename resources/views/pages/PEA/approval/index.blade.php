@extends('layouts.main')
@section('content')
@php
use App\Helper\MyHelper;
$checkAccessParams['userAccess'] = Session::get('UserAccess');
$checkAccessParams['moduleID'] = env('MODULE_PEA');
@endphp


<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Probationary Employee Assessment</a></li>
                        <li class="breadcrumb-item active">Approval</li>
                    </ol>
                </div>
                <h4 class="page-title">Probationary Employee Assessment</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap" style="background-color:rgb(77,97,112)">
                    <div class="col-md-11">
                        <h4 class="text-white">Approval</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <input type="hidden" name="_token" id="globalToken" value="{{csrf_token()}}" />
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="forApproval"> Approval Status: </label> <br>
                                    <select name="forApproval" id="forApproval" class="form-control select2no">
                                        <option value="0" @if ($paramPEAApproval['forApproval'] == 0) {{ 'selected' }} @endif>For Approval</option>
                                        <option value="1" @if ($paramPEAApproval['forApproval'] == 1) {{ 'selected' }} @endif>Approved</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="controlNo"> Control No.: </label> <br>
                                    <input type="text" name="controlNo" id="controlNo" value="{{$paramPEAApproval['controlNo']}}" placeholder="Control #" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="employeeName"> Employee Name: </label> <br>
                                    <input type="text" name="employeeName" id="employeeName" value="{{$paramPEAApproval['employeeName']}}" placeholder="Employee" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-xxl">
                                    <label for="position"> Position: </label> <br>
                                    <select name="position" id="position" class="form-control select2 w-150" style="width:200%">
                                        {{-- <option value="0">-SELECT POSITION-</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="row pl-4">
                                <div class="col-xxl">
                                    <label for="location"> Location: </label> <br>
                                    <select name="location" id="location" class="form-control select2 w-150" style="width:200%">
                                        {{-- <option value="0">-SELECT POSITION-</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                            <div class="row pl-3 pb-2">
                                <div class="col-md-12">
                                    <label for="fdatestart"> Filed Date Start: </label> <br>
                                    <input type="date" name="fdatestart" id="fdatestart" value="{{$paramPEAApproval['fdatestart']}}" placeholder="Control #" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="fdateend"> Filed Date End: </label> <br>
                                    <input type="date" name="fdateend" id="fdateend" value="{{$paramPEAApproval['fdateend']}}" placeholder="Control #" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="hdatestart"> Hired Date Start: </label> <br>
                                    <input type="date" name="hdatestart" id="hdatestart" value="{{$paramPEAApproval['hdatestart']}}" placeholder="Control #" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="fdateend"> Hired Date End: </label> <br>
                                    <input type="date" name="hdateend" id="hdateend" value="{{$paramPEAApproval['hdateend']}}" placeholder="Control #" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-5">
                                <div class="col-md-12 pt-3">
                                    <button type="button" id="BtnFilterSubmitA" class="btn btn-info waves-effect waves-light mb-2 mr-1"><i class="mdi mdi-magnify mr-1"></i>Search</button>
                                    <button type="button" id="BtnFilterReset" class="btn btn-secondary waves-effect waves-light mb-2"><i class="mdi mdi-restart"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Legend --}}
    <div>
        <table class="table table-bordered w-100 h-1 nowrap " id="legendcolor" style="height: 1%">
            <th style="background-color: rgb(231,161,176)">HR - Rated</th>
            <th style="background-color: rgb(92,179,255)">AC - Rated</th>
            <th style="background-color: rgb(255,243,128)">AM - Rated</th>
            <th style="background-color: rgb(200,162,200)">HR - Approved</th>
            <th style="background-color: rgb(188,233,84)">BM - Approved</th>
        </table>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-1 text-center">
                        <div class="col">
                            @if (MyHelper::decrypt(Session::get('PositionLevel_ID'))==2) <button type="button" class="btn btn-success" name="btnApprove" id="btnApprove">Approve</button> @endif
                        </div>
                    </div>
                    <table id="tbl_pea_approval" class="table table-centered w-100 nowrap">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>Ratings</th>
                                <th>Control #</th>
                                <th>Employee No.</th>
                                <th>Full Name</th>
                                <th>Position</th>
                                <th>Date Hired</th>
                                <th>Department</th>
                                <th>Location</th>
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
