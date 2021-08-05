$(document).ready(function() {

    $('#position').select2({
        placeholder: "Select Position"
    });

    $('#type').select2({
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


    var tbl_bi_inprocess = $('#tbl_bi_inprocess').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        ajax      : {
            url: WebURL + '/BI-get',
            method: 'POST',
            data: function (data) {
                var withBI = $('#withBI').val();
                var employeeName = $('#employeeName').val();
                var position = $('#position').val();
                var fdatestart = $('#fdatestart').val();
                var fdateend = $('#fdateend').val();
                var token = $('#globalToken').val()

                data.withBI = withBI;
                data.employeeName = employeeName;
                data.position = position;
                data.fdatestart = fdatestart;
                data.fdateend = fdateend;
                data.token = token;

            },
            dataType: 'json',
        },
        columns   :[
            {data:"DateHired"},
            {data:"FullName",render:function(data, type, row){
                return '<a href="'+WebURL+'/BI-filing/'+row.Employee_ID+'"class="text-info" id="fileBI">'+row.FullName+'</a>'}},
            {data:"LocationCode", render:function(data, type, row, meta){
                return row.LocationCode + " - " + row.Location
            }},
            {data:"Department"},
            {data:"Position"},
            {data:"PositionLevel"},
            {data:"DateFiled"}

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
            tbl_bi_inprocess.ajax.reload();
        },
    });


    $('#BtnFilterSubmit').on('click', function(){
        tbl_bi_inprocess.ajax.reload()
    })

    $('#btnSaveBI').on('click',function(){
        formdata = $('#form_bi').serialize();

        console.log(formdata);
        swal.fire({
            title: 'Are you sure?',
            text: "Saving B.I.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm:(done) =>
            {
                return new Promise(function(resolve, reject) {
                Swal.getCancelButton().setAttribute('disabled', '')
                $.post(WebURL + '/BI-insert',formdata,function(data){
                    if(data.num>=0)
                    {
                        swal.fire({
                            title: 'Success',
                            text: data.msg,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                            }).then(function (result) {
                                if (true) {
                                   location.reload();
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
    })

    $('#btnUpdateBI').on('click',function(){
        formdata = $('#form_bi').serialize();

        console.log(formdata);
        swal.fire({
            title: 'Are you sure?',
            text: "Updating B.I.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm:(done) =>
            {
                return new Promise(function(resolve, reject) {
                    Swal.getCancelButton().setAttribute('disabled', '')
                    $.post(WebURL + '/BI-update',formdata,function(data){
                        if(data.num>=0)
                        {
                            swal.fire({
                                title: 'Success',
                                text: data.msg,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                                }).then(function (result) {
                                    if (true) {
                                    location.reload();
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
    })

    var tbl_bi_approval = $('#tbl_bi_approval').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        ajax      : {
            url: WebURL + '/BI-app-get',
            method: 'POST',
            data: function (data) {
                var appStatus = $('#appStatus').val();
                var employeeName = $('#employeeName').val();
                var position = $('#position').val();
                var type = $('#type').val();
                var fdatestart = $('#fdatestart').val();
                var fdateend = $('#fdateend').val();
                var token = $('#globalToken').val()

                data.appStatus = appStatus;
                data.employeeName = employeeName;
                data.position = position;
                data.type = type;
                data.fdatestart = fdatestart;
                data.fdateend = fdateend;
                data.token = token;

            },
            dataType: 'json',
        },
        columns   :[
            {data:"DateHired"},
            {data:"FullName",render:function(data, type, row){
                return '<a href="'+WebURL+'/BI-filing/'+row.EmployeeID+'"class="text-info" id="fileBI">'+row.FullName+'</a>'}},
            {data:"LocationCode", render:function(data, type, row, meta){
                return row.LocationCode + " - " + row.Location
            }},
            {data:"Department"},
            {data:"Position"},
            {data:"PositionLevel"},
            {data:"DateFiled"}

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

    $('#type').on('change',function(){
        tbl_bi_approval.ajax.reload();
    })

    $('#BtnFilterSubmitA').on('click', function(){
        tbl_bi_approval.ajax.reload()
    })


    $('#btnApprove').on('click' ,function(){
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
                var formdata = $('#form_bi').serialize();
                    $.post(WebURL + '/pin-check',{PIN:PIN},function(data){
                        if(data == 1)
                        {
                            $.post(WebURL + '/BI-approve',formdata,function(data){
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



///
});


