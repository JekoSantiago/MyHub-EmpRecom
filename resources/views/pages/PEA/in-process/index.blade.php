@extends('layouts.main')
@section('content')


<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Probationary Employee Assessment</a></li>
                        <li class="breadcrumb-item active">In-Process</li>
                    </ol>
                </div>
                <h4 class="page-title">Probationary Employee Assessment</h4>
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
                                    <label for="forRating"> Rate Status: </label> <br>
                                    <select name="forRating" id="forRating" class="form-control">
                                        <option value="0" @if ($paramPEAFiled['forRating'] == 0) {{ 'selected' }} @endif>For Rating</option>
                                        <option value="1" @if ($paramPEAFiled['forRating'] == 1) {{ 'selected' }} @endif>>Rated</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="controlNo"> Control No.: </label> <br>
                                    <input type="text" name="controlNo" id="controlNo" value="{{$paramPEAFiled['controlNo']}}" placeholder="Control #" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="employeeName"> Employee Name: </label> <br>
                                    <input type="text" name="employeeName" id="employeeName" value="{{$paramPEAFiled['employeeName']}}" placeholder="Employee" class="form-control">
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
                            <div class="row pl-5">
                                <div class="col-md-12 pt-3">
                                    <button type="button" id="BtnFilterSubmit" class="btn btn-info waves-effect waves-light mb-2 mr-1"><i class="mdi mdi-magnify mr-1"></i>Search</button>
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
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="text-sm-left">
                                    <button type="button" data-toggle="modal" data-target="#modal_new_pea" class="btn btn-info waves-effect waves-light mb-2 mr-1"><i class="mdi mdi-plus-circle mr-1"></i>Create New</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <table id="tbl_pea_inprocess" class="table table-centered w-100 nowrap">
                        <thead>
                            <tr>
                                <th>Control #</th>
                                <th>Employee No.</th>
                                <th>Full Name</th>
                                <th>Position</th>
                                <th>Date Hired</th>
                                <th>Location</th>
                                <th>Action</th>
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
<script src="{{ URL::asset('assets/js/custom/PEA.js')}}"></script>
@endsection
