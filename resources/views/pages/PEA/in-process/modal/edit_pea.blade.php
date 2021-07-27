<div id="modal_edit_pea" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update PEA</h4>
            </div>
            <div class="modal-body">
                <form id="form_edit_pea">
                    <fieldset>
                        <input type="hidden" name="FiledID" id="FiledID">
                        <div class="form-group">
                            <select name="edit_pea_employee" id="edit_pea_employee" class="form-control select2">
                            </select>
                            <label class="invalid-feedback" id="edit_pea_employee_error">Select an employee</label>
                        </div>
                    </fieldset>

                    <div class="text-center">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" id="btn_add_pea" class="btn btn-success">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
