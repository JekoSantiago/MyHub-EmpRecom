$(document).ready(function() {


    $('#position').select2({
        placeholder: "Select Position"
    });

    $('.select2no').select2({
        minimumResultsForSearch: -1
    });

    $.ajax({
        url:WebURL+'/get-pos',
        type:'GET',
        dataType: 'text',
        cache: false,
        success: function (data) {
            $('#position').html(data);
        },
        error: function () {
            console.log('error');
        }
    })

    $('#location').select2({
        placeholder: "Select Location"
    });

    if($('#location').is(':visible'))
    {
        $.ajax({
            url:WebURL+'/get-loc',
            type:'GET',
            dataType: 'text',
            cache: false,
            success: function (data) {
                $('#location').html(data);
            },
            error: function () {
                console.log('error');
            }
        })
    }



    $("#modal_new_pea").on('shown.bs.modal', function () {

        $('#new_pea_employee').select2({
            dropdownParent: $('#modal_new_pea'),
            placeholder: "Select Employee"

        });

        $.ajax({
            url:WebURL+'/get-emp',
            type:'GET',
            dataType: 'text',
            cache: false,
            success: function (data) {
                $('#new_pea_employee').html(data);
            },
            error: function () {
                console.log('error');
            }
        })

   });

   $('#btn_add_pea').on('click',function(){

       var error = false;
       var EmpID = $('#new_pea_employee').val();

       if (EmpID.length <= 0)
       {
           error = true;
           $('#new_pea_employee').addClass('error-input');
           $('#new_pea_employee_error').show();
       }
       else
       {

           $('#new_pea_employee').removeClass('error-input');
           $('#new_pea_employee_error').hide();
       }

       if (error == false)
       {
        swal.fire({
            title: 'Are you sure?',
            text: "Creating New PEA",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm:(done) =>
            {
                return new Promise(function(resolve, reject) {
                Swal.getCancelButton().setAttribute('disabled', '')
                $.post(WebURL + '/PEA-insert',{EmpID:EmpID},function(data){
                    if(data.num>=0)
                    {
                        swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                            }).then(function (result) {
                                if (true) {
                                    $('#modal_new_pea').modal('hide');
                                    tbl_pea_inprocess.ajax.reload( null, false );
                                }
                            })
                    }
                    else
                    {
                        swal.fire({
                            title: "Warning!",
                            text: data.msg,
                            icon: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false,
                        });
                    }
                })
            });
            }
          })
       }
   })


    var tbl_pea_inprocess = $('#tbl_pea_inprocess').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        ajax      : {
            url: WebURL + '/PEA-get',
            method: 'POST',
            data: function (data) {
                var forRating = $('#forRating').val();
                var controlNo = $('#controlNo').val();
                var employeeName = $('#employeeName').val();
                var position = $('#position').val();
                var token = $('#globalToken').val()


                data.forRating = forRating;
                data.controlNo = controlNo;
                data.employeeName = employeeName;
                data.position = position;
                data.token = token;

            },
            dataType: 'json',
        },
        columns   :[
            {data:"ControlNum",render:function(data, type, row){
                return '<a href="'+WebURL+'/PEA-rating/'+row.Filed_ID+'"class="text-info" id="rateemp">'+row.ControlNum+'</a>'}},
            {data:"EmployeeNo"},
            {data:"FullName"},
            {data:"Position"},
            {data:"DateHired"},
            {data:"LocationID", render:function(data, type, row, meta){
                return row.LocationCode + " - " + row.Location
            }},
            {render:function(data, type, row){
                var update = '';
                if(row.HRRateStatus == 0 && isHR==0)
                {
                    update = '<a href="javascript:void(0)" class="text-info updatePEA"> <i class="mdi mdi-24px mdi-account-edit"></i></a>' ;
                }
                return update;
            }}
        ],
        language: {
            emptyTable: 'No data available.',
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            processing:'<div class="text-center"><div class="spinner spinner-border"></div></div>'
        },
        error: function (xhr, error, code)
        {
            tbl_pea_inprocess.ajax.reload();
        },
        createdRow: function (row, data, index){

            if(data.AMAppDate != null && data.HRAppDate != null && data.ExecAppDate != null) {
                $(row).css("background-color", "#BAE654");
            }

            else if(data.AMAppDate != null && data.HRAppDate != null && data.ExecAppDate == null) {
                $(row).css("background-color", "#C6A0C6");
            }

            else if(data.AMAppDate != null && data.HRAppDate == null && data.ExecAppDate == null) {
                $(row).css("background-color", "#FCF17F");
            }

            else if(data.EmpAccDate != null && data.AMAppDate == null && data.HRAppDate == null && data.ExecAppDate == null) {
                $(row).css("background-color", "#F9C181");
            }

            else if(data.NumOfQuestRemain == 0 && data.MonthEvalCommentCount == 3 && data.RecomComment.length>0 && data.Res_Accomp_Answer.length>0 && data.Scope_Answer.length>0 && data.Str_Exp_Answer.length>0) {
                $(row).css("background-color", "#5CB1FC");
            }

            else if(data.HRRateStatus == 1 && data.NumOfQuestRemain > 0) {
                // $(row).css("background-color", "#E4A0AE");
            }

        },
        initComplete:function()
        {
            if(isHR==1)
            {
                tbl_pea_inprocess.column(6).visible(false);
            }
        }
    });

    $('#BtnFilterSubmit').on('click', function(){
        tbl_pea_inprocess.ajax.reload()
    })

    $('#BtnFilterSubmitA').on('click', function(){
        tbl_pea_approval.ajax.reload()
        if($('#forApproval').val()==1)
        {
            if(ApproveType == 3)
            {
                tbl_pea_approval.column(0).visible(false);
                $('#btnApprove').hide();
            }
        }
        else
        {
            if(ApproveType == 3)
            {
                tbl_pea_approval.column(0).visible(true);
                $('#btnApprove').show();
            }
        }
    })

    $('body').on('click','.updatePEA',function(e){
        var data = tbl_pea_inprocess.row( $(this).parents('tr') ).data();
        console.log(data);

        var FiledID = data['Filed_ID'];
        $('#FiledID').val(FiledID);

        console.log(FiledID);

        $('#modal_edit_pea').modal('show');
        $('#edit_pea_employee').select2({
            dropdownParent: $('#modal_edit_pea'),
            placeholder: "Select Employee"

        });


        $.ajax({
            url:WebURL+'/get-emp',
            type:'GET',
            dataType: 'text',
            cache: false,
            success: function (data) {
                $('#edit_pea_employee').html(data);
            },
            error: function () {
                console.log('error');
            }
        })

    })

    $('#btn_update_pea').on('click',function(e){
        var error = false;
        var FiledID = $('#FiledID').val();
        var EmpID = $('#edit_pea_employee').val();

        console.log(EmpID);
        if (EmpID.length <= 0)
        {
            error = true;
            $('#edit_pea_employee').addClass('error-input');
            $('#edit_pea_employee_error').show();
        }

        if(error == false)
        {
            swal.fire({
                title: 'Are you sure?',
                text: "Updating  PEA",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                preConfirm:(done) =>
                {
                    return new Promise(function(resolve, reject) {
                    Swal.getCancelButton().setAttribute('disabled', '')
                    $.post(WebURL + '/PEA-update',{EmpID:EmpID,FiledID:FiledID},function(data){
                        if(data.num>=0)
                        {
                            swal.fire({
                                title: 'Success',
                                text: data.msg,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                                }).then(function (result) {
                                    if (true) {
                                        $('#modal_edit_pea').modal('hide');
                                        tbl_pea_inprocess.ajax.reload( null, false );
                                    }
                                })
                        }
                        else
                        {
                            swal.fire({
                                title: "Warning!",
                                text: data.msg,
                                icon: "warning",
                                confirmButtonText: "Ok",
                                confirmButtonColor: '#3085d6',
                                allowOutsideClick: false,
                            });
                        }
                    })
                });
                }
            })
        }

    })

    /**
     *  Approval PEA
     */

     var tbl_pea_approval = $('#tbl_pea_approval').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        ajax      : {
            url: WebURL + '/PEA-Approval-get',
            method: 'POST',
            data: function (data) {
                var forApproval = $('#forApproval').val();
                var controlNo = $('#controlNo').val();
                var employeeName = $('#employeeName').val();
                var position = $('#position').val();
                var location = $('#location').val();
                var fdatestart = $('#fdatestart').val();
                var fdateend = $('#fdateend').val();
                var hdatestart = $('#hdatestart').val();
                var hdateend = $('#hdateend').val();
                var token = $('#globalToken').val()

                data.forApproval = forApproval;
                data.controlNo = controlNo;
                data.employeeName = employeeName;
                data.position = position;
                data.token = token;
                data.location=location;
                data.fdatestart = fdatestart;
                data.fdateend = fdateend;
                data.hdatestart = hdatestart;
                data.hdateend = hdateend;

            },
            dataType: 'json',
        },
        columns   :[
            {render:function(data,type,row){
                return '<input type="checkbox" name="batchAppr" value="'+ row.Filed_ID +'">'
            }},
            {data:"TotalPoint"},
            {data:"ControlNum",render:function(data, type, row){
                return '<a href="'+WebURL+'/PEA-rating/'+row.Filed_ID+'"class="text-info">'+row.ControlNum+'</a>'}},
            {data:"EmployeeNo"},
            {data:"FullName"},
            {data:"Position"},
            {data:"DateHired"},
            {data:"Department"},
            {data:"LocationID", render:function(data, type, row, meta){
                return row.LocationCode + " - " + row.Location
            }},

        ],
        language: {
            emptyTable: 'No data available.',
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            processing:'<div class="text-center"><div class="spinner spinner-border"></div></div>'
        },
        error: function (xhr, error, code)
        {
            tbl_pea_approval.reload();
        },
        createdRow: function (row, data, index){
            if(data.AMAppDate != null && data.HRAppDate != null && data.ExecAppDate != null) {
                $(row).css("background-color", "#BAE654");
            }

            else if(data.AMAppDate != null && data.HRAppDate != null && data.ExecAppDate == null) {
                $(row).css("background-color", "#C6A0C6");
            }

            else if(data.AMAppDate != null && data.HRAppDate == null && data.ExecAppDate == null) {
                $(row).css("background-color", "#FCF17F");
            }

            else if(data.EmpAccDate != null) {
                $(row).css("background-color", "#F9C181");
            }

            else if(data.HRRateStatus == 1 && data.NumOfQuestRemain == 0) {
                $(row).css("background-color", "#5CB1FC");
            }

            else if(data.HRRateStatus == 1 && data.NumOfQuestRemain > 0) {
                // $(row).css("background-color", "#E4A0AE");
            }
        },
        initComplete: function(row) {
            console.log($('#forApproval').val());
            if (ApproveType != 3)
            {
                tbl_pea_approval.column(0).visible(false);
                tbl_pea_approval.column(1).visible(false);
            }

        }

    });

    $('#checkAll').click(function () {
        $('input:checkbox').prop('checked', this.checked);
    });

    var batchApp=[];
    $('#btnApprove').on('click',function(){
        batchApp=[];
        $("input:checkbox[name=batchAppr]:checked").each(function(){
            batchApp.push($(this).val());
        });
        if(batchApp.length <= 0)
        {
            swal.fire({
                title: "Warning!",
                text: "There are no selected employees",
                icon: "warning",
                confirmButtonText: "Ok",
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
            });
        }
        else
        {
            swal.fire({
                title: 'Enter PIN',
                showCancelButton: true,
                html: '<input type="password" id="pin" class="swal2-input" placeholder="####"  maxlength="4">',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                preConfirm:(done) =>
                {
                    return new Promise(function(resolve, reject) {
                    Swal.getCancelButton().setAttribute('disabled', '')
                    var PIN = Swal.getPopup().querySelector('#pin').value
                        $.post(WebURL + '/pin-check',{PIN:PIN},function(data){
                            if(data == 1)
                            {
                                $.post(WebURL + '/PEA-batch-approval',{FiledID:batchApp},function(data){
                                    if(data.num>=0)
                                    {
                                        swal.fire({
                                            title: "Success!",
                                            text: data.msg,
                                            icon: "success",
                                            confirmButtonText: "Ok",
                                            confirmButtonColor: '#3085d6',
                                            allowOutsideClick: false,
                                        });
                                        tbl_pea_approval.ajax.reload();
                                        $('#checkAll').attr('checked',false);
                                    }
                                    else
                                    {
                                        swal.fire({
                                            title: "Warning!",
                                            text: data.msg,
                                            icon: "warning",
                                            confirmButtonText: "Ok",
                                            confirmButtonColor: '#3085d6',
                                            allowOutsideClick: false,
                                        });
                                    }
                                })
                            }
                            else
                            {
                                swal.fire({
                                    title: "Warning!",
                                    text: "Wrong PIN",
                                    icon: "warning",
                                    confirmButtonText: "Ok",
                                    confirmButtonColor: '#3085d6',
                                    allowOutsideClick: false,
                                });
                            }

                        })
                    });
                }
            })
        }

    })

    var tbl_pea_reports = $('#tbl_pea_reports').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        ajax      : {
            url: WebURL + '/PEA-report',
            method: 'GET',
        },
        columns   :[
            {data:"Location"},
            {data:"ACFullName"},
            {data:"AMFullName"},
            {data:"CountFailedSubmit"},
            {data:"CountFailedAssessment"},
            {data:"CountFailedAttendance"},
            {data:"CountFailedAttitude"},
            {data:"CountAwol"},
            {data:"CountResigned"},
            {data:"TotalPass"},
            {data:"TotalEmp"},

        ],
        language: {
            emptyTable: 'No data available.',
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            processing:'<div class="text-center"><div class="spinner spinner-border"></div></div>'
        },

    });

    $('body').on('click', '#BtnFilterReset', function () {

        $('#controlNo').val('');
        $('#employeeName').val('');
        $('#fdatestart').val('');
        $('#fdateend').val('');
        $('#hdatestart').val('');
        $('#hdateend').val('');
        $('.select2').val(null).trigger('change');
        $('#forRating').val(-1).trigger('change');

    });


 ///////
});
