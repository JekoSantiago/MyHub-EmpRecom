$(document).ready(function() {

    $('#position').select2({
        placeholder: "Select Position"
    });

    $('#department').select2({
        placeholder: "Select Department"
    });

    $('.select2no').select2({
        minimumResultsForSearch: -1
    });

    $.ajax({
        url:WebURL+'/get-dept',
        type:'GET',
        dataType: 'text',
        cache: false,
        success: function (data) {
            $('#department').html(data);
        },
        error: function () {
            console.log('error');
        }
    })

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

    var tbl_npa = $('#tbl_npa').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        ajax      : {
            url: WebURL + '/NPA-get',
            method: 'POST',
            data: function (data) {
                var forApproval = $('#forApproval').val();
                var department = $('#department').val();
                var employeeName = $('#employeeName').val();
                var position = $('#position').val();
                var token = $('#globalToken').val()


                data.forApproval = forApproval;
                data.department = department;
                data.employeeName = employeeName;
                data.position = position;
                data.token = token;

            },
            dataType: 'json',
        },
        columns   :[
            {render:function(data,type,row){
                return '<input type="checkbox" name="batchAppr" value="'+ row.Employee_ID +'">'
            }},
            {data:"TotalPoint"},
            {data:"EmployeeNo",render:function(data, type, row){
                return '<a href="'+WebURL+'/NPA-Form/'+row.Employee_ID+'"class="text-info" id="npaForm">'+row.EmployeeNo+'</a>'}},
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
        initComplete:function()
        {
            if(BatchApproval==0)
            {
            tbl_npa.column(0).visible(false);
            }
        }

    });


    $('#BtnFilterSubmitA').on('click', function(){
        tbl_npa.ajax.reload()
        if($('#forApproval').val()==1)
        {
            if(BatchApproval > 0)
            {
                tbl_npa.column(0).visible(false);
                $('#btnApprove').hide();
            }
        }
        else
        {
            if(BatchApproval > 0)
            {
                tbl_npa.column(0).visible(true);
                $('#btnApprove').show();
            }
        }
    })

    $('#btnApproveA').on('click' ,function(){
        swal.fire({
            title: 'Approve',
            showCancelButton: true,
            html: '<h5> Enter PIN: </h5><input type="password" id="pin" class="swal2-input" placeholder="####"  maxlength="4">',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm:(done) =>
            {
                return new Promise(function(resolve, reject) {
                Swal.getCancelButton().setAttribute('disabled', '')
                var PIN = Swal.getPopup().querySelector('#pin').value
                var EmpID = $('#EmpID').val();
                    $.post(WebURL + '/pin-check',{PIN:PIN},function(data){
                        if(data == 1)
                        {
                            $.post(WebURL + '/NPA-approve',{EmpID:EmpID},function(data){
                                if(data.num>=0)
                                {
                                    swal.fire({
                                        title: "Success!",
                                        text: data.msg,
                                        icon: "success",
                                        confirmButtonText: "Ok",
                                        confirmButtonColor: '#3085d6',
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                          location.reload();
                                      });
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
    })



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
                                $.post(WebURL + '/NPA-batch-app',{EmpIDs:batchApp},function(data){
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
                                        tbl_npa.ajax.reload();
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

    $('#modal_pea').on('show.bs.modal', function (e) {
        var FileID = $('#FileID').val();
        var remoteLink = WebURL + '/NPA-showPEA/'+FileID;

        $("#modal_pea").find('.modal-body').html('<div class="text-center"><div class="spinner spinner-border"></div></div>');
        $('#modal_pea').find('.modal-body').load(remoteLink,function () {

            $('#modal_pea').find('input, textarea').attr('disabled','disabled');

        });
    });


    $('body').on('click', '#BtnFilterReset', function () {

        $('#employeeName').val('');
        $('.select2').val(null).trigger('change');
    });

//
})
