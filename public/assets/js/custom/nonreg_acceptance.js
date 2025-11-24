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

    $('#BtnFilterSubmit').on('click',function(){
        tbl_nonreg_accept.draw();
    })

    $('body').on('click', '#BtnFilterReset', function () {

        $('#employeeName').val('');
        $('.select2').val(null).trigger('change');
    });

//-- NONREG ACCEPTANCE --//
    var tbl_nonreg_accept = $('#tbl_nonreg_accept').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        ajax      : {
            url: WebURL + '/nonreg-accepptanceDT',
            method: 'POST',
            data: function (data) {
                var forRating = $('#forRating').val();
                var employeeName = $('#employeeName').val();
                var position = $('#position').val();
                var token = $('#globalToken').val()

                data.forRating = forRating;
                data.employeeName = employeeName;
                data.position = position;
                data.token = token;

            },
            dataType: 'json',
        },
        columns   :[
            {render:function(data, type, row){
                var view = '';
                if(row.Approved == 1)
                {
                    view = '<a href="javascript:void(0)" class="text-success btnAcceptNonReg" > <i class="mdi mdi-24px mdi-check"></i></a>' ;
                }
                return view;
            }},
            {data:"TotalPoint"},
            {data:"EmployeeNo"},
            {data:"FullName"},
            {data:"Position"},
            {data:"DateHired"},
            {data:"LocationID", render:function(data, type, row, meta){
                return row.LocationCode + " - " + row.Location
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
        createdRow: function (row, data, dataIndex){
            if(data.Approved == 2) {
                $(row).css("background-color", "#BAE654");
            }
        },
        initComplete:function()
        {

        }
    });

    $('body').on('click','.btnAcceptNonReg',function(){
        var data = tbl_nonreg_accept.row( $(this).parents('tr') ).data();
        var empID = data.Employee_ID
        var empNo = data.EmployeeNo
        var NonRegID = data.NonRegApp_ID;
        console.log(data);
        swal.fire({
            title: 'Accept',
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
                    $.post(WebURL + '/emppin-check',{PIN:PIN,empID:empID,empNo:empNo},function(data){
                        if(data == 1)
                        {
                            $.post(WebURL + '/accept-nonreg',{NonRegID:NonRegID},function(data){
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
                                        tbl_nonreg_accept.ajax.reload(null,false);
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
    });

//-- END NONREG ACCEPTANCE --//




///

})
