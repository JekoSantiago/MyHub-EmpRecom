@extends('layouts.main')
@section('content')
@php
use App\Helper\MyHelper;
$checkAccessParams['userAccess'] = Session::get('UserAccess');
$checkAccessParams['moduleID'] = env('MODULE_PEA');
@endphp
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Probationary Employee Assessment</a></li>
                    <li class="breadcrumb-item active">Ratings</li>
                </ol>
            </div>
            <h4 class="page-title">Probationary Employee Assessment</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-11">
        @if($emp[0]->ExecAppDate != null)
        <a href="{{ route('RPT_PEA', ['Filed_ID' => request()->segment(2)]) }}" target="_blank"><button type="button" class="btn btn-lg btn-outline-light" style="background-color: #2C8F4F;">PEA</button> </a>&nbsp;
        @endif
        @if ($showNPA == 1 && MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        <a href="{{ route('RPT_NPA',['Employee_ID' => $emp[0]->Employee_ID]) }}" target="_blank"><button type="button" class="btn btn-lg btn-outline-light" style="background-color: #2C788F;">NPA</button></a> &nbsp;
        @endif
        @if ($showBI == 1 && MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
        <a href="{{ route('RPT_BI',['Employee_ID' => $emp[0]->Employee_ID]) }}" target="_blank"><button type="button" class="btn btn-lg btn-outline-light" style="background-color: #8F2C3E;">BI</button></a> &nbsp;
        @endif
        @if($emp[0]->ExecAppDate != null)
        <a href="{{ route('RPT_EP',['Filed_ID' => request()->segment(2)]) }}" target="_blank"><button type="button" class="btn btn-lg btn-outline-light" style="background-color: #A7B941;">EP</button></a> &nbsp;
        @endif
        @if($showNR == 1)
        <a href="{{ route('RPT_RL',['Filed_ID' => request()->segment(2), 'RATINGS' => $emp[0]->TotalPoint,'Employee_ID' => $emp[0]->Employee_ID]) }}" target="_blank"><button type="button" class="btn btn-lg btn-outline-light" style="background-color: #A9772B;">RL</button> </a>&nbsp;
        @endif
    </div>
    <div class="col-lg-1 pt-1">
        @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_APPROVE')]))
        <a href="{{ route('PEA_Approval')}}"><button type="button" class="btn btn-outline-secondary">Back</button></a>
        @else
        <a href="{{ route('PEA_Filed') }}"><button type="button" class="btn btn-outline-secondary">Back</button></a>
        @endif
    </div>
</div>
@if (MyHelper::decrypt(Session::get('PositionLevel_ID')) == 5 && MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID') && $emp[0]->NumOfAnswered > 0)
<div class="container-fluid pt-3" id="hr-warn">
    <div class="row">
        <div class="col-12">
            <div class="card hr-warn" >
                <div class="card-body text-light">
                    <i class="mdi mdi-24px mdi-alert-circle-outline"></i> <span style="font-size: 120%"> This employee is already locked for regularization, actions at this state are disabled.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tbl_emp_info" class="table table-bordered w-100 nowrap">
                        <tbody>
                            <tr>
                                <td>
                                    <b>Employee No:</b> <br> {{ $emp[0]->EmployeeNo }}
                                </td>
                                <td>
                                    <b>Employee Name:</b> <br> {{ $emp[0]->FullName }}
                                </td>
                                <td>
                                    <b>Position:</b> <br> {{ $emp[0]->Position }}
                                </td>
                                <td>
                                    <b>Date Hired:</b> <br> {{ $emp[0]->DateHired }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Department:</b> <br> {{ $emp[0]->Department }}
                                </td>
                                <td>
                                    <b>Branch:</b> <br> {{ $emp[0]->LocationCode . ' - ' . $emp[0]->Location }}
                                </td>
                                <td>
                                    <b>Educational Attainment:</b> <br> {{ $emp[0]->SchoolType }}
                                </td>
                                <td>
                                    <b>Evaluator:</b> <br> {{ $emp[0]->EmpEvaluatorFullName }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="form_ratings">
                        <input type="hidden" name="FiledID" id="FiledID" value="{{ $emp[0]->Filed_ID }}">
                        <input type="hidden" name="_token" id="globalToken" value="{{csrf_token()}}" />
                    </form>
                    <table id="tbl_emp_ratings" class="table table-bordered w-100 nowrap">
                        <tbody>
                            <tr>
                                <td colspan="5">
                                    <b>Instruction:</b> The Evaluator must objectively rate the performance of the employee using the appropriate weight/score guide below. Please be guided by the description specified in each factor. <br> &emsp; &emsp; &emsp; &emsp; &nbsp; <span style="background-color: #B1D0FF">&emsp;&emsp;&emsp;&emsp;</span> - Evaluator  <br> &emsp; &emsp; &emsp; &emsp; &nbsp; <span style="background-color: #FFC6D6">&emsp;&emsp;&emsp;&emsp;</span> - HR
                                </td>
                            </tr>
                            @foreach ( $chapter as $ch )
                                <tr>
                                    <td colspan="5" style="text-align: center">
                                        <b>{{ $ch->Chapter }}</b>
                                    </td>
                                </tr>
                                @foreach ( $factor as $fact => $fval )
                                    @if ($fval->Chapter_ID == $ch->Chapter_ID)
                                        <tr @if ($fval->isForHR == 1) style="background-color: #FFC6D6" @else style="background-color: #B1D0FF"  @endif>
                                            <td>
                                                <b>{{ $fval->FactorName }}</b> <br> {{ $fval->FactorDesc }}
                                            </td>
                                            <td>
                                                <b>Percentage</b>
                                            </td>
                                            <td>
                                                <b>1st Month</b>
                                            </td>
                                            <td>
                                                <b>2nd Month</b>
                                            </td>
                                            <td>
                                                <b>3rd Month</b>
                                            </td>
                                        </tr>
                                @foreach ( $option as $opt => $opval )
                                    @if ($opval->Factor_ID == $fval->Factor_ID)
                                    <tr @if ($fval->isForHR == 1) style="background-color: #FFC6D6" @else style="background-color: #B1D0FF"  @endif>
                                        <td>
                                                {{ $opval->Description }}
                                            </td>
                                            <td>
                                                {{ $opval->Percentage }}%
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input rad_{{ $opval->Factor_ID }}" type="radio" form="form_ratings" name="M1_{{ $opval->Factor_ID }}"  value="{{ $opval->RatingOption_ID }}" @foreach($rating as $rate) @if($opval->RatingOption_ID == $rate->First_ID) checked @endif @endforeach>
                                                </div>
                                            </td>
                                            <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input rad_{{ $opval->Factor_ID }}" type="radio" form="form_ratings" name="M2_{{ $opval->Factor_ID }}" value="{{ $opval->RatingOption_ID }}"@foreach($rating as $rate) @if($opval->RatingOption_ID == $rate->Second_ID) checked @endif @endforeach>
                                                    </div>
                                            </td>
                                            <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input rad_{{ $opval->Factor_ID }}" type="radio" form="form_ratings" name="M3_{{ $opval->Factor_ID }}"  value="{{ $opval->RatingOption_ID }}"@foreach($rating as $rate) @if($opval->RatingOption_ID == $rate->Third_ID) checked @endif @endforeach >
                                                    </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                            <tr>
                                <td colspan="5" style="text-align: right">
                                    <h4 class="pr-4">TOTAL AVERAGE: <span id="AvePoint">{{ $emp[0]->TotalPoint ? : 0 }}</span></h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tbl_ratingscale" class="table table-bordered w-100 nowrap">
                        <tbody>
                            <tr>
                                <td colspan="2" style="text-align: center">
                                   <h5><b> RATING SCALE </b></h5>
                                </td>
                            </tr>
                        @foreach ( $scale as $sc )
                            <tr id="r_{{ $sc->RatingScale_ID }}">
                                <td>
                                    {{ $sc->PercentRange }}
                                </td>
                                <td>
                                    {{ $sc->Definition }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tbl_comment" class="table table-bordered w-100 nowrap">
                        <thead>
                            <tr>
                                <th style="width: 5%"></th>
                                <th>Month</th>
                                <th>Evaluator Comment</th>
                                <th>Evaluator Name</th>
                                <th>Date Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr>
                                <td>
                                    @if ($comment[0]->Filed_ID == NULL)
                                        <a href="javascript:void(0)" id="m1_comment" class="text-info">
                                            <i data-feather="message-square"></i>
                                        </a>
                                    @else
                                    <a href="javascript:void(0)" id="m1_update" class="text-info">
                                        <i data-feather="edit"></i>
                                    </a>
                                    @endif
                                </td>
                                <td>1st</td>
                                <td>{{ $comment[0]->EvalComment }}</td>
                                <td>{{ $comment[0]->EvalFullName}}</td>
                                <td>{{ $comment[0]->DateComment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    @if ($comment[1]->Filed_ID == NULL)
                                        <a href="javascript:void(0)" id="m2_comment" class="text-info">
                                            <i data-feather="message-square"></i>
                                        </a>
                                    @else
                                    <a href="javascript:void(0)" id="m2_update" class="text-info">
                                        <i data-feather="edit"></i>
                                    </a>
                                    @endif
                                </td>
                                <td>2nd</td>
                                <td>{{ $comment[1]->EvalComment }}</td>
                                <td>{{ $comment[1]->EvalFullName}}</td>
                                <td>{{ $comment[1]->DateComment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    @if ($comment[2]->Filed_ID == NULL)
                                        <a href="javascript:void(0)" id="m3_comment" class="text-info">
                                            <i data-feather="message-square"></i>
                                        </a>
                                    @else
                                    <a href="javascript:void(0)" id="m3_update" class="text-info">
                                        <i data-feather="edit"></i>
                                    </a>
                                    @endif
                                </td>
                                <td>3rd</td>
                                <td>{{ $comment[2]->EvalComment }}</td>
                                <td>{{ $comment[2]->EvalFullName}}</td>
                                <td>{{ $comment[2]->DateComment }}</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="form_emp_profile">
    <input type="hidden" name="FiledIDRec" id="FiledIDRec" value="{{ $emp[0]->Filed_ID }}">
    <input type="hidden" name="_token" id="globalToken" value="{{csrf_token()}}" />

</form>

<div class="container-fluid pt-3" id="recomForm" @if($emp[0]->TotalPoint <= 79) style="display: none" @endif>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Recommendation Letter Comment (must be filled up by Evaluator)</h4>
                    <div class="form-group">
                        <textarea name="recom_letter" form="form_emp_profile" id="recom_letter" cols="30" rows="10" class="form-control" placeholder="Recomendation letter...">{{ $emp[0]->RecomComment }}</textarea>
                        <label class="invalid-feedback" id="recom_letter_error">Please fill up the field</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Employee Profile (must be filled up by Evaluator)</h4>
                    <div class="form-group">
                        <div class="row">
                            <label for="PRA">
                                Performance Results and Accomplishments
                            </label>
                            <textarea name="PRA" id="PRA" cols="30" rows="6" class="form-control" form="form_emp_profile">{{ $emp[0]->Res_Accomp_Answer }}</textarea>
                            <label class="invalid-feedback" id="PRA_error">Please fill up the field</label>
                        </div>
                        <div class="row pt-2">
                            <label for="SnE">
                                Strengths and Expertise
                            </label>
                            <textarea name="SnE" id="SnE" cols="30" rows="6" class="form-control" form="form_emp_profile">{{ $emp[0]->Str_Exp_Answer }}</textarea>
                            <label class="invalid-feedback" id="SnE_error">Please fill up the field</label>
                        </div>
                        <div class="row pt-2">
                            <label for="SAR">
                                Scope of Assignment and Responsibility (Branch/Clusters/Region/Function)
                            </label>
                            <textarea name="SAR" id="SAR" cols="30" rows="6" class="form-control" form="form_emp_profile">{{ $emp[0]->Scope_Answer }}</textarea>
                            <label class="invalid-feedback" id="SAR_error">Please fill up the field</label>
                        </div>
                        <div class="row pt-2 d-flex">
                            <div class="col-md-5">
                                <button type="button" class="btn btn-success" name="btnSaveEval" id="btnSaveEval"
                                @if((Myhelper::decrypt(Session::get('Department_ID')) == env('OPS_DEPT_ID') && $emp[0]->AMAppDate != null)  || (Myhelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID') && $emp[0]->HRAppDate != null) || ($emp[0]->ExecAppDate != null && Myhelper::decrypt(Session::get('PositionLevel_ID')) <= 2 &&  $emp[0]->DisAppDate != null) )
                                style="display: none;" @endif>SAVE</button>
                            </div>
                            <div class="col">
                                @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_APPROVE')]))
                                    @if((Myhelper::decrypt(Session::get('Department_ID')) == env('OPS_DEPT_ID') && $emp[0]->AMAppDate == null)  || (Myhelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID') && $emp[0]->HRAppDate == null) || ($emp[0]->ExecAppDate == null && Myhelper::decrypt(Session::get('PositionLevel_ID')) <= 2 &&  $emp[0]->DisAppDate == null) )
                                        <button type="button" class="btn btn-success" name="btnApprove" id="btnApprove">Approve</button>
                                        @if(Myhelper::decrypt(Session::get('Department_ID')) == env('OPS_DEPT_ID') && Myhelper::decrypt(Session::get('PositionLevel_ID')) <= 2)
                                        <button type="button" class="btn btn-danger" name="btnCancelApp" id="btnCancelApp">Cancel</button>
                                        @else
                                        <button type="button" class="btn btn-danger" name="btnDisapprove" id="btnDisapprove">Disapprove</button>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tbl_signs" class="table table-bordered w-100 nowrap">
                        <tbody>
                            <tr>
                                <td>
                                    <h5><b>Recommended By:</b> &emsp; {{ $emp[0]->AMName }}<br><br><b>Approved Date:</b> &emsp; {{ ($emp[0]->AMAppDate) ? date('d-m-Y', strtotime($emp[0]->AMAppDate)) : '' }}</b></h5>
                                </td>
                                <td>
                                    <h5><b>Approved By: &emsp;</b> {{ $emp[0]->ExecName }}<br><br><b>Approved Date:</b> &emsp;{{ ($emp[0]->ExecAppDate) ? date('d-m-Y', strtotime($emp[0]->ExecAppDate)) : '' }}</b></h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5><b>Checked and Reviewed By: &emsp;</b> {{ $emp[0]->HRName }}<br><br><b>Approved Date:</b>&emsp; {{ ($emp[0]->HRAppDate) ? date('d-m-Y', strtotime($emp[0]->HRAppDate)) : '' }}</b></h5>
                                </td>
                                <td>
                                    @if($emp[0]->DisAppDate != NULL)<h5 class="text-danger"><b>Disapproved By:</b>&emsp; {{ $emp[0]->DisAppName }}<br><br><b>Disapproved Date:</b>&emsp; {{ ($emp[0]->DisAppDate) ? date('d-m-Y', strtotime($emp[0]->DisAppDate)) : '' }}<br><br><b>Comments:</b> &emsp;{{ $emp[0]->DisAppComments }}</h5>@endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.PEA.ratings.modal.comment')
@endsection
@section('js')
<script src="{{ URL::asset('assets/js/custom/ratings.js')}}"></script>
<script src="{{ URL::asset('assets/js/custom/approval.js')}}"></script>
@endsection
