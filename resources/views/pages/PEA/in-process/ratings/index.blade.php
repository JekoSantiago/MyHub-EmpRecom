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
        <button type="button" class="btn btn-lg btn-outline-light" style="background-color: #2C8F4F;">PEA</button>
        <button type="button" class="btn btn-lg btn-outline-light" style="background-color: #A7B941;">EP</button>
        <button type="button" class="btn btn-lg btn-outline-light" style="background-color: #A9772B;">RL</button>
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
                                                <fieldset id="{{ $fval->Factor_ID }}">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="1M_{{ $opval->Factor_ID }}" id="" value="{{ $opval->Percentage }}" >
                                                </div>
                                                </fieldset>
                                            </td>
                                            <td>
                                                <fieldset id="{{ $fval->Factor_ID }}">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="2M_{{ $opval->Factor_ID }}" id="" value="{{ $opval->Percentage }}" >
                                                    </div>
                                                </fieldset>
                                            </td>
                                            <td>
                                                <fieldset id="{{ $fval->Factor_ID }}">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="3M_{{ $opval->Factor_ID }}" id="" value="{{ $opval->Percentage }}" >
                                                    </div>
                                                </fieldset>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                            <tr>
                                <td colspan="5" style="text-align: right">
                                    <h4 class="pr-4">TOTAL AVERAGE: </h4>
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
                            <tr @if ($sc->RatingScale_ID == 4) style="background-color: #fc5252; color:#fff" @endif>
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
                        <tbody>
                            <tr>
                                <th>Month</th>
                                <th>Evaluator Comment</th>
                                <th>Evaluator Name</th>
                                <th>Date Comment</th>
                            </tr>
                            <tr>
                                <td>1st</td>
                            </tr>
                            <tr>
                                <td>2nd</td>
                            </tr>
                            <tr>
                                <td>3rd</td>
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
                    <div class="form-group">
                        <div class="row">
                            <label for="PRA">
                                Performace Results and Accomplishments
                            </label>
                            <textarea name="PRA" id="PRA" cols="30" rows="6" class="form-control"></textarea>
                        </div>
                        <div class="row pt-2">
                            <label for="SnE">
                                Strengths and Expertise
                            </label>
                            <textarea name="SnE" id="SnE" cols="30" rows="6" class="form-control"></textarea>
                        </div>
                        <div class="row pt-2">
                            <label for="SAR">
                                Scope of Assignment and Responsibility (Branch/Clusters/Region/Function)
                            </label>
                            <textarea name="SAR" id="SAR" cols="30" rows="6" class="form-control"></textarea>
                        </div>
                        <div class="row pt-2">
                            <button type="button" class="btn btn-success" name="btnSaveEval" id="btnSaveEval">SAVE</button>
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

@endsection
@section('js')
<script src="{{ URL::asset('assets/js/custom/ratings.js')}}"></script>
@endsection
