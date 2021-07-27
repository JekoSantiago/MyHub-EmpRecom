$(document).ready(function() {

    $('#position').select2({
        placeholder: "Select Position"
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
                            confirmButtonColor: '#6658dd',
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
                return '<a href="javascript:void(0) "class="text-info pearate">'+row.ControlNum+'</a>'}},
            {data:"Employee_ID"},
            {data:"FullName"},
            {data:"Position"},
            {data:"DateHired"},
            {data:"LocationID", render:function(data, type, row, meta){
                return row.LocationCode + " - " + row.Location
            }},
            {render:function(data, type, row){
                return '<a href="javascript:void(0)" class="text-info updatePEA"> <i class="mdi mdi-24px mdi-account-edit"></i></a>' ;
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
    });

    $('#BtnFilterSubmit').on('click', function(){
        tbl_pea_inprocess.ajax.reload()
    })

    $('body').on('click','.updatePEA',function(e){
        var data = tbl_pea_inprocess.row( $(this).parents('tr') ).data();
        console.log(data);
    })







 ///////
});
