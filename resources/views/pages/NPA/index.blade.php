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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Notice of Personnel Action</a></li>
                        <li class="breadcrumb-item active">Approval</li>
                    </ol>
                </div>
                <h4 class="page-title">Notice of Personnel Action</h4>
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
                    <div class="col">
                       @if (MyHelper::decrypt(Session::get('PositionLevel_ID'))<=2) <button type="button" class="btn btn-success" name="btnApprove" id="btnApprove">Approve</button> @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <input type="hidden" name="_token" id="globalToken" value="{{csrf_token()}}" />
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="forApproval"> Approval Status: </label> <br>
                                    <select name="forApproval" id="forApproval" class="form-control">
                                        <option value="0" @if ($paramNPA['forApproval'] == 0) {{ 'selected' }} @endif>For Approval</option>
                                        <option value="1" @if ($paramNPA['forApproval'] == 1) {{ 'selected' }} @endif>Approved</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="employeeName"> Employee Name: </label> <br>
                                    <input type="text" name="employeeName" id="employeeName" value="{{$paramNPA['employeeName']}}" placeholder="Employee" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col">
                                    <label for="department"> Department: </label> <br>
                                    <select name="department" id="department" class="form-control select2 w-150" style="width:200%">
                                        <option value="0"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col">
                                    <label for="position"> Position: </label> <br>
                                    <select name="position" id="position" class="form-control select2 w-150" style="width:200%">
                                        <option value="0"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row pl-5">
                                <div class="col-md-12 pt-3">
                                    <button type="button" id="BtnFilterSubmitA" class="btn btn-info waves-effect waves-light mb-2 mr-1"><i class="mdi mdi-magnify mr-1"></i>Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tbl_npa" class="table table-centered w-100 nowrap">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>Ratings</th>
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
<script src="{{ URL::asset('assets/js/custom/NPA.js')}}"></script>
@endsection
