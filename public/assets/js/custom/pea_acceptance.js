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


//-- PEA ACCEPTANCE --//
    var tbl_pea_accept = $('#tbl_pea_accept').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        ajax      : {
            url: WebURL + '/pea-accepptanceDT',
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
            {data:"ControlNum"},
            {data:"EmployeeNo"},
            {data:"FullName"},
            {data:"Position"},
            {data:"DateHired"},
            {data:"LocationID", render:function(data, type, row, meta){
                return row.LocationCode + " - " + row.Location
            }},
            {render:function(data, type, row){
                var view = '';
                    view = '<a href="javascript:void(0)" class="text-info viewPEA" > <i class="mdi mdi-24px mdi-eye"></i></a>' ;
                return view;
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
        createdRow: function (row, data, index){
            if(data.EmpAccDate != null) {
                $(row).css("background-color", "#BAE654");
            }
        },
        initComplete:function()
        {
            // if (ApproveType != 3)
            // {
            //     tbl_pea_approval.column(0).visible(false);
            //     tbl_pea_approval.column(1).visible(false);
            // }
        }
    });

    $('#BtnFilterSubmit').on('click',function(){
        tbl_pea_accept.draw();
    })

    $('body').on('click', '#BtnFilterReset', function () {

        $('#employeeName').val('');
        $('.select2').val(null).trigger('change');
    });

    $('body').on('click','.viewPEA',function(e){
        var data = tbl_pea_accept.row( $(this).parents('tr') ).data();
        var FileID = data.Filed_ID


        if(data.hasSignature == 1 && data.PIN != null)
        {
            $('#modal_pea').modal('show');
            var remoteLink = WebURL + '/accept-showPEA/'+FileID;

            $("#modal_pea").find('.modal-body').html('<div class="text-center"><div class="spinner spinner-border"></div></div>');
            $('#modal_pea').find('.modal-body').load(remoteLink,function () {

                $('#modal_pea').find('input, textarea').attr('disabled','disabled');

            });
        }
        else if (data.hasSignature == 0)
        {
            swal.fire({
                title: "No Signature",
                html: data.FullName + " has no signature. <br> Please register a signature in MyHub",
                icon: "warning",
                confirmButtonText: "Ok",
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
            });
        }
        else
        {
            swal.fire({
                title: "No PIN",
                html: data.FullName + " has no PIN. <br> Please update PIN in MyHub",
                icon: "warning",
                confirmButtonText: "Ok",
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
            });
        }


    })

    $('body').on('click','#btnAcceptPEA',function(){
        var empID = $('#EmpID').val();
        var empNo = $('#EmpNo').val();
        var FiledID = $('#FiledID').val();
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
                            $.post(WebURL + '/accept-pea',{FiledID:FiledID,empID:empID},function(data){
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
                                        $('#modal_pea').modal('hide');
                                        tbl_pea_accept.ajax.reload(null,false);
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

//-- END PEA ACCEPTANCE--//

///

})
