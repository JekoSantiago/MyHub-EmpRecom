<div class="container-fluid pt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" id="FileID" value="{{ $emp[0]->Filed_ID }}">
                    <input type="hidden" id="EmpID" value="{{ $emp[0]->Employee_ID }}">
                    <input type="hidden" id="EmpNo" value="{{ $emp[0]->EmployeeNo }}">

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
                                    <b class="text-dark">DATE</b><br>{{ date('Y-m-d',strtotime($emp[0]->DateRecommended)) }}
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
                                <td colspan="2" rowspan="2">
                                    <b class="text-dark">RECOMMENDED BY</b><br>{{ $emp[0]->RecommendedBy . ' - ' . date('Y-m-d',strtotime($emp[0]->DateRecommended)) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <b class="text-dark">CHECKED & REVIEWED BY</b><br>{{ $emp[0]->CheckedAndReviewed1 . ' - ' .  date('Y-m-d',strtotime($emp[0]->CheckAndReviewed1Date)) }}  @if($emp[0]->CheckedAndReviewed2 != NULL) <br> {{ $emp[0]->CheckedAndReviewed2 . ' - ' . date('Y-m-d',strtotime($emp[0]->CheckAndReviewed2Date)) }}  @endif  @if($emp[0]->CheckedAndReviewed3 != NULL) <br> {{ $emp[0]->CheckedAndReviewed3 . ' - ' .  date('Y-m-d',strtotime($emp[0]->CheckAndReviewed3Date))  }}  @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b class="text-dark">APPROVED BY</b><br>{{ $emp[0]->ApprovedBy . ' - ' . date('Y-m-d',strtotime($emp[0]->ApprovedDate))}}
                                </td>
                                <td colspan="2">
                                    <b class="text-dark">ACCEPTED BY</b><br>{{ $emp[0]->AcceptedBy }}
                                </td>
                                <td>
                                    <b class="text-dark">DATE</b><br>@if($emp[0]->AcceptedDate != NULL){{ date('Y-m-d',strtotime($emp[0]->AcceptedDate)) }}@endif
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
                            <button type="button" class="btn btn-success" name="btnAcceptNPA" id="btnAcceptNPA">Accept</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
