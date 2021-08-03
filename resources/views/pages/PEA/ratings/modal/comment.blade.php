<div id="modal_comment" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="title_comment"></span> month</h4>
            </div>
            <div class="modal-body">
                <form id="form_comment">
                    <input type="hidden" name="FiledID" id="FiledID" value="{{ $emp[0]->Filed_ID }}">
                    <input type="hidden" name="MonthID" id="MonthID" value="">
                    <input type="hidden" name="EmpID" id="EmpID" value="{{ $emp[0]->Employee_ID }}">
                    <input type="hidden" name="CommentID" id="CommentID" value="">
                    <fieldset>
                        <div class="form-group">
                            <textarea name="monthly_comment" id="monthly_comment" cols="30" rows="5" class="form-control"> </textarea>
                            <label class="invalid-feedback" id="monthly_comment_error">Enter a comment.</label>
                        </div>
                    </fieldset>
                    <div class="text-center">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" id="btn_save_comment" class="btn btn-success">Save</button>
                        <button type="button" id="btn_edit_comment" class="btn btn-info">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
