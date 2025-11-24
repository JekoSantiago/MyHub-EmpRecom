@extends('layouts.main')
@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Acceptance</a></li>
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">PEA</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Acceptance</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background-color:rgb(77,97,112)">
                    <h4 class="text-white">PEA</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <input type="hidden" name="_token" id="globalToken" value="{{csrf_token()}}" />
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="forRating"> Rate Status: </label> <br>
                                    <select name="forRating" id="forRating" class="form-control select2no">
                                        <option value="-1" @if ($paramPEAAccept['forRating'] == -1) {{ 'selected' }} @endif>All</option>
                                        <option value="0" @if ($paramPEAAccept['forRating'] == 0) {{ 'selected' }} @endif>For Acceptance</option>
                                        <option value="1" @if ($paramPEAAccept['forRating'] == 1) {{ 'selected' }} @endif>Accepted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="controlNo"> Control No.: </label> <br>
                                    <input type="text" name="controlNo" id="controlNo" value="{{$paramPEAAccept['controlNo']}}" placeholder="Control #" class="form-control">
                                </div>
                            </div>
                            <div class="row pl-3">
                                <div class="col-md-12">
                                    <label for="employeeName"> Employee Name: </label> <br>
                                    <input type="text" name="employeeName" id="employeeName" value="{{$paramPEAAccept['employeeName']}}" placeholder="Employee" class="form-control">
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
                                    <button type="button" id="BtnFilterReset" class="btn btn-secondary waves-effect waves-light mb-2"><i class="mdi mdi-restart"></i></button>
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
                    <table id="tbl_pea_accept" class="table table-centered w-100 nowrap">
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
@include('pages.Accept.pea.modals.modal_pea')
@endsection
@section('js')
<script src="{{ URL::asset('assets/js/custom/pea_acceptance.js')}}"></script>
@endsection
