@extends('layouts.main')
@section('content')
@php use App\Helper\MyHelper; @endphp


<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Background Investigation</a></li>
                        <li class="breadcrumb-item active">In-Process</li>
                    </ol>
                </div>
                <h4 class="page-title">Background Investigation</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background-color:rgb(77,97,112)">
                    <h4 class="text-white">In-Process</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <input type="hidden" name="_token" id="globalToken" value="{{csrf_token()}}" />
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="withBI"> BI Status: </label> <br>
                                    <select name="withBI" id="withBI" class="form-control select2no">
                                        <option value="0" @if ($paramBI['withBI'] == 0) {{ 'selected' }} @endif>Without BI</option>
                                        <option value="1" @if ($paramBI['withBI'] == 1) {{ 'selected' }} @endif>With BI</option>
                                        <option value="2" @if ($paramBI['withBI'] == 2) {{ 'selected' }} @endif>All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="employeeName"> Employee Name: </label> <br>
                                    <input type="text" name="employeeName" id="employeeName" value="{{$paramBI['employeeName']}}" placeholder="Employee" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="position"> Position: </label> <br>
                                    <select name="position" id="position" class="form-control select2 w-150" style="width:200%">
                                    </select>
                                </div>
                            </div>
                            <div class="row pl-3 pb-2">
                                <div class="col-md-12">
                                    <label for="fdatestart"> Filed Date Start: </label> <br>
                                    <input type="date" name="fdatestart" id="fdatestart" value="{{$paramBI['fdatestart']}}" placeholder="Control #" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="fdateend"> Filed Date End: </label> <br>
                                    <input type="date" name="fdateend" id="fdateend" value="{{$paramBI['fdateend']}}" placeholder="Control #" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-5">
                                <div class="col-md-12 pt-3">
                                    <button type="button" id="BtnFilterSubmit" class="btn btn-info waves-effect waves-light mb-2 mr-1"><i class="mdi mdi-magnify mr-1"></i>Search</button>
                                    <button type="button" id="BtnFilterReset" class="btn btn-secondary waves-effect waves-light mb-2"><i class="mdi mdi-restart"></i></button>
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
                    <table id="tbl_bi_inprocess" class="table table-centered w-100 nowrap">
                        <thead>
                            <tr>
                                <th>Date Hired</th>
                                <th>Full Name</th>
                                <th>Location</th>
                                <th>Department</th>
                                <th>Position</th>
                                <th>Position Level</th>
                                <th>Filed Date</th>
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

@include('pages.PEA.in-process.modal.new_pea')
@include('pages.PEA.in-process.modal.edit_pea')
@endsection
@section('js')
<script src="{{ URL::asset('assets/js/custom/BI.js')}}"></script>
@endsection
