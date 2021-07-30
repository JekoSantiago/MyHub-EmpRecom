@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Probationary Employee Assessment</a></li>
                    <li class="breadcrumb-item">In-Process</li>
                    <li class="breadcrumb-item active">Ratings</li>
                </ol>
            </div>
            <h4 class="page-title">Probationary Employee Assessment</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-11">
        <button type="button" class="btn btn-lg btn-outline-light" style="background-color: #2C8F4F;">PEA</button> &nbsp;
        <button type="button" class="btn btn-lg btn-outline-light" style="background-color: #A7B941;">EP</button> &nbsp;
        <button type="button" class="btn btn-lg btn-outline-light" style="background-color: #A9772B;">RL</button> &nbsp;
    </div>
    <div class="col-lg-1 pt-1">
        <a href="#"><button type="button" class="btn btn-outline-secondary">Back</button></a>
    </div>
</div>

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
                    <form id="form_ratings"> <input type="hidden" name="FiledID" id="FiledID" value="{{ $emp[0]->Filed_ID }}"></form>
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

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Recommendation Letter Comment (must be filled up by Evaluator)</h4>
                    <form id="form_emp_profile">
                        <div class="form-group">
                            <textarea name="recom_letter" id="recom_letter" cols="30" rows="10" class="form-control" placeholder="Recomendation letter...">{{ $emp[0]->RecomComment }}</textarea>
                            <label class="invalid-feedback" id="recom_letter_error">Please fill up the field</label>
                            <input type="hidden" name="FiledIDRec" id="FiledIDRec" value="{{ $emp[0]->Filed_ID }}">
                        </div>
                    </form>
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
                                Performace Results and Accomplishments
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
                                <button type="button" class="btn btn-success" name="btnSaveEval" id="btnSaveEval">SAVE</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary" name="btnApprove" id="btnApprove">Approve</button>
                                <button type="button" class="btn btn-danger" name="btnDisapprove" id="btnDisapprove">Disapprove</button>
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
                                    <h5><b>Recommended By:<br><br>Approved Date:</b></h5>
                                </td>
                                <td>
                                    <h5><b>Approved By:<br><br>Approved Date:</b></h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5><b>Checked and Reviewed By:<br><br>Approved Date:</b></h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.PEA.in-process.modal.comment')
@endsection
@section('js')
<script src="{{ URL::asset('assets/js/custom/ratings.js')}}"></script>
@endsection
