@extends('layouts.main')
@section('content')


<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">List of Probationary Employees</a></li>
                    </ol>
                </div>
                <h4 class="page-title">List of Probationary Employees</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tbl_probi" class="table table-centered w-100 nowrap">
                        <thead>
                            <tr>
                                <th>Employee Status</th>
                                <th>Date Hired</th>
                                <th>Employee No.</th>
                                <th>Full Name</th>
                                <th>Position</th>
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
<script src="{{ URL::asset('assets/js/custom/Probi.js')}}"></script>
@endsection
