$(document).ready(function() {

    var FiledID = $('#FiledID').val();
    $('#btnApprove').on('click' ,function(){
        swal.fire({
            title: 'Enter PIN',
            showCancelButton: true,
            html: '<input type="password" id="pin" class="swal2-input" placeholder="Password"  maxlength="4">',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
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
                            $.post(WebURL + '/PEA-Approval-insert',{FiledID:FiledID},function(data){
                                if(data.num>=0)
                                {
                                    swal.fire({
                                        title: "Success!",
                                        text: data.msg,
                                        icon: "success",
                                        confirmButtonText: "Ok",
                                        confirmButtonColor: '#6658dd',
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
                                        confirmButtonColor: '#6658dd',
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
                                confirmButtonColor: '#6658dd',
                                allowOutsideClick: false,
                            });
                        }

                    })
                });
            }
        })
    })

})
