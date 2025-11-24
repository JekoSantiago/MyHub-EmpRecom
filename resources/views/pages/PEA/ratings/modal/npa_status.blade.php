<div id="modal_npa_status" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">NPA Status</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b>RECOMMENDED BY:</b></td>
                            <td>{{ ($npa[0]->RecommendedBy) ? : '-' }}</td>
                            <td>{{ (date("Y-m-d", strtotime($npa[0]->DateRecommended))) ? : '-' }}</td>
                        </tr>
                        <tr>
                            <td rowspan="3"><b>CHECKED & REVIEWED BY:</b></td>
                            <td>{{ ($npa[0]->CheckedAndReviewed1) ? : '-' }}</td>
                            <td>{{ (date("Y-m-d", strtotime($npa[0]->CheckAndReviewed1Date)) != '1970-01-01') ? date("Y-m-d", strtotime($npa[0]->CheckAndReviewed1Date)): '-' }}</td>
                        </tr>
                        <tr>
                            <td>{{ ($npa[0]->CheckedAndReviewed2) ? : '-' }}</td>
                            <td>{{ (date("Y-m-d", strtotime($npa[0]->CheckAndReviewed2Date)) != '1970-01-01') ? date("Y-m-d", strtotime($npa[0]->CheckAndReviewed2Date)): '-' }}</td>
                        </tr>
                        <tr>
                            <td>{{ ($npa[0]->CheckedAndReviewed3 ) ? : '-' }}</td>
                            <td>{{ (date("Y-m-d", strtotime($npa[0]->CheckAndReviewed3Date)) != '1970-01-01') ? date("Y-m-d", strtotime($npa[0]->CheckAndReviewed3Date)): '-'  }}</td>
                        </tr>
                        <tr>
                            <td><b>APPROVED BY:</b></td>
                            <td>{{ ($npa[0]->ApprovedBy) ? : '-'  }}</td>
                            <td>{{ (date("Y-m-d", strtotime($npa[0]->ApprovedDate)) != '1970-01-01') ? date("Y-m-d", strtotime($npa[0]->ApprovedDate)): '-'  }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
