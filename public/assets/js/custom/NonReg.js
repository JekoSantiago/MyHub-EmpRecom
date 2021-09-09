$(document).ready(function() {

    $('#position').select2({
        placeholder: "Select Position"
    });

    $('#department').select2({
        placeholder: "Select Department"
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

    var tbl_nonreg_approval = $('#tbl_nonreg_approval').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        ajax      : {
            url: WebURL + '/NonReg-get',
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
        }
    });


    $('#BtnFilterSubmitA').on('click', function(){
        tbl_nonreg_approval.ajax.reload()
        if($('#forApproval').val()==1)
        {
            tbl_nonreg_approval.column(0).visible(false);
            $('#btnApprove').hide();
        }
        else
        {
            tbl_nonreg_approval.column(0).visible(true);
            $('#btnApprove').show();
        }
    })



    $('#checkAll').click(function () {
        $('input:checkbox').prop('checked', this.checked);
    });

    var batchApp=[];
    $('.card').on('click','#btnApprove',function(){
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
                                $.post(WebURL + '/NonReg-approve',{EmployeeID:batchApp},function(data){
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
                                        tbl_nonreg_approval.ajax.reload();
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

    $('body').on('click', '#BtnFilterReset', function () {

        $('#employeeName').val('');
        $('.select2').val(null).trigger('change');
    });

    $('.select2no').select2({
        minimumResultsForSearch: -1,
    });

})
