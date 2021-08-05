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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Background Investigation</a></li>
                    <li class="breadcrumb-item active">Filing</li>
                </ol>
            </div>
            <h4 class="page-title">Background Investigation</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-11">
    </div>
    <div class="col-lg-1 pt-1">
        @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_APPROVE')]))
        <a href="{{ route('BI_Approval')}}"><button type="button" class="btn btn-outline-secondary">Back</button></a>
        @else
        <a href="{{ route('BI_Filed') }}"><button type="button" class="btn btn-outline-secondary">Back</button></a>
        @endif    </div>
</div>

<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <form id="form_bi">
                            <input type="hidden" id="employeeID" name="employeeID" value="{{ request()->segment(2) }}">
                            <input type="hidden" id="BI_ID" name="BI_ID" value="{{ (empty($emp)) ? 0 : $emp[0]->BI_ID }}">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col">
                                    <div>
                                        <h5><b>SUBJECT:</b> {{ (empty($emp)) ? '' : $emp[0]->FullName }}</h5>
                                    </div>
                                    <div>
                                        <h5><b>POSITION:</b> {{ (empty($emp)) ? '' : $emp[0]->Position }}</h5>
                                    </div>
                                    <div>
                                        <h5><b>BRANCH:</b> {{ (empty($emp)) ? '' : $emp[0]->Location }}</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row pt-4">
                                <div class="col-xs-2">
                                    <h5><b>SUMMARY:</b> &emsp;
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="summary" id="summary" value="{{ (empty($emp)) ? '' : $emp[0]->Summary }}">
                                </div>
                            </div>
                            <div class="row pt-1">
                                <h5><b>DETAIL:</b></h5>
                            </div>
                            <div class="row pt-3">
                                <div class="col-md-6">
                                    <h5><b>A. CHARACTER REFERENCE</b></h5>
                                    <textarea name="charref" id="charref" cols="30" rows="4" class="form-control">{{ (empty($emp)) ? '' : $emp[0]->CharacterRef }}</textarea>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-6">
                                    <h5><b>B. COMMUNITY REFERENCE</b></h5>
                                    <textarea name="comref" id="comref" cols="30" rows="4" class="form-control">{{ (empty($emp)) ? '' : $emp[0]->CommunityRef }}</textarea>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-6">
                                    <h5><b>C. EDUCATIONAL REFERENCE</b></h5>
                                    <textarea name="educref" id="educref" cols="30" rows="4" class="form-control">{{ (empty($emp)) ? '' : $emp[0]->EducationalRef }}</textarea>
                                </div>
                            </div>

                            <div class="row pt-3">
                                <div class="col">
                                    <h5>Prepared By:<br><br> <u><b>{{ (empty($emp)) ? '' : $emp[0]->CreatorFullName }}</b></u> <br> <i>{{ (empty($emp)) ? '' : $emp[0]->CreatorPosition }}</i></h5>
                                </div>
                            </div>

                            <div class="row pt-3">
                                <div class="col">
                                    <h5>Validated True and Correct:<br><br> <u><b>{{ (empty($emp)) ? '' : $emp[0]->ApproverFullName }}</b></u> <br> <i>{{ (empty($emp)) ? '' : $emp[0]->ApprovedPosition }}</i></h5>
                                </div>
                            </div>

                            <div class="row pt-4 d-flex">
                                @if(empty($emp))
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" name="btnSaveBI" id="btnSaveBI">SAVE</button>
                                </div>
                                @else
                                    @if($emp[0]->ApproverID == NULL)
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-info" name="btnUpdateBI" id="btnUpdateBI">Update</button>
                                    </div>
                                    @endif
                                @endif
                                <div class="col">
                                    @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_APPROVE')]) && $emp[0]->ApproverID == NULL)
                                        <button type="button" class="btn btn-success" name="btnApprove" id="btnApprove">Approve</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{ URL::asset('assets/js/custom/BI.js')}}"></script>
@endsection
