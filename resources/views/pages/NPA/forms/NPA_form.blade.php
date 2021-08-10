@extends('layouts.main')
@section('content')
@php
use App\Helper\MyHelper;
$checkAccessParams['userAccess'] = Session::get('UserAccess');
$checkAccessParams['moduleID'] = env('MODULE_BI');
@endphp
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Notice of Personnel Action</a></li>
                    <li class="breadcrumb-item active">NPA Form</li>
                </ol>
            </div>
            <h4 class="page-title">Notice of Personnel Action</h4>
        </div>
    </div>
</div>

<div class="row  d-flex">
    <div class="col-lg-10">
    </div>
    <div class="col-lg-1 pt-1">
        <button type="button" data-toggle="modal" data-target="#modal_pea" class="btn btn-danger waves-effect waves-light">PEA</button>
    </div>
    <div class="col-lg-1 pt-1">
        <a href="{{ route('NPA') }}"><button type="button" class="btn btn-outline-secondary">Back</button></a>
    </div>
</div>

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" id="FileID" value="{{ $emp[0]->Filed_ID }}">
                    <input type="hidden" id="EmpID" value="{{ $emp[0]->Employee_ID }}">
                    <table class="table table-bordered">
                        <tbody>
                            <tr rowspan='2'>
                                <td>
                                    <b class="text-dark">EMPLOYEE NO</b><br>{{ $emp[0]->EmployeeNo }}
                                </td>
                                <td colspan="2">
                                    <h5 class="text-center"><b>NOTICE OF PERSONNEL ACTION</b></h5>
                                </td>
                                <td colspan="2">
                                    <b class="text-dark">DATE</b>
                                </td>
                            </tr>
                            <tr rowspan='2'>
                                <td>
                                    <b class="text-dark">NAME OF EMPLOYEE</b><br>{{ $emp[0]->FullName }}
                                </td>
                                <td>
                                    <b class="text-dark">DATE HIRED</b><br>{{ $emp[0]->DateHired }}
                                </td>
                                <td>
                                    <b class="text-dark">DIVISION</b><br>{{ $emp[0]->Location }}
                                </td>
                                <td colspan="2">
                                    <b class="text-dark">DEPARTMENT</b><br>{{ $emp[0]->Department }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <b class="text-dark">YOU ARE HEREBY NOTIFIED OF THE FOLLOWING ACTIONS AFFECTING YOUR EMPLOYMENT:</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class="text-dark">NATURE OF ACTION</b>
                                </td>
                                <td>
                                    <b class="text-dark">FROM</b>
                                </td>
                                <td>
                                    <b class="text-dark">CODE</b>
                                </td>
                                <td>
                                    <b class="text-dark">TO</b>
                                </td>
                                <td>
                                    <b class="text-dark">CODE</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class="text-dark">Change of employment status</b>
                                </td>
                                <td>
                                    {{ $emp[0]->EmpStatusFrom }}
                                </td>
                                <td>
                                    {{ $emp[0]->EmpStatusCodeFrom }}
                                </td>
                                <td>
                                    {{ $emp[0]->EmpStatusTo }}
                                </td>
                                <td>
                                    {{ $emp[0]->EmpStatusCodeTo }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class="text-dark">Promotion : Level</b>
                                </td>
                                <td>
                                    {{ $emp[0]->PositionLevel }}
                                </td>
                                <td>
                                    {{ $emp[0]->PositionLevelCode }}
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class="text-dark">Promotion Title</b>
                                </td>
                                <td>
                                    {{ $emp[0]->Position }}
                                </td>
                                <td>
                                    {{ $emp[0]->PositionCode }}
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class="text-dark">Transfer</b>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class="text-dark">Others</b>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class="text-dark">Resignation (V)</b>
                                </td>
                                <td colspan="2">
                                    <b class="text-dark">Termination of Employment (P)</b>
                                </td>
                                <td colspan="2">
                                    <b class="text-dark">Termination of Cause (D)</b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b class="text-dark">PARTICULARS</b>
                                </td>
                                <td colspan="3">
                                    <b class="text-dark">EFFECTIVE</b><br>{{ $emp[0]->EffectiveDate }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b class="text-dark">RECOMMENDED BY</b><br>{{ $emp[0]->RecommendedBy }}
                                </td>
                                <td colspan="3">
                                    <b class="text-dark">CHECKED & REVIEWED BY</b><br>{{ $emp[0]->CheckedAndReviewed1 }} @if($emp[0]->CheckedAndReviewed2 != NULL) / {{ $emp[0]->CheckedAndReviewed2 }}  @endif  @if($emp[0]->CheckedAndReviewed3 != NULL) / {{ $emp[0]->CheckedAndReviewed3 }}  @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b class="text-dark">APPROVED BY</b><br>{{ $emp[0]->ApprovedBy }}
                                </td>
                                <td colspan="2">
                                    <b class="text-dark">ACCEPTED BY</b><br>{{ $emp[0]->FullName }}
                                </td>
                                <td>
                                    <b class="text-dark">DATE</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b class="text-dark">DISTRIBUTION</b>
                                </td>
                                <td>
                                    <b class="text-dark">1 - EMPLOYEE</b>
                                </td>
                                <td>
                                    <b class="text-dark">2 - PAYROLL</b>
                                </td>
                                <td colspan="2">
                                    <b class="text-dark">3 - 201 FILE</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($AppEnable == 1)
                    <div class="row">
                        <div class="col-md-12 pt-3 text-center">
                            <button type="button" class="btn btn-success" name="btnApproveA" id="btnApproveA">Approve</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.NPA.modals.modal_pea')
@endsection
@section('js')
<script src="{{ URL::asset('assets/js/custom/NPA.js')}}"></script>
@endsection
