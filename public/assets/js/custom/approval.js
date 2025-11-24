$(document).ready(function() {

    var FiledID = $('#FiledID').val();
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
                    $.post(WebURL + '/pin-check',{PIN:PIN},function(data){
                        if(data == 1)
                        {
                            $.post(WebURL + '/PEA-Approval-insert',{FiledID:FiledID,Type:1},function(data){
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

    $('#btnCancelApp').on('click' ,function(){
        swal.fire({
            title: 'Cancel',
            showCancelButton: true,
            html: '<h5> Comment: </h5><textarea name="remarks" id="remarks" cols="30" rows="5" class="swal2-input" placeholder="Remarks..."> </textarea> <br> <h5> Enter PIN: </h5> <input type="password" id="pin" class="swal2-input" placeholder="####"  maxlength="4">',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm:(done) =>
            {
                return new Promise(function(resolve, reject) {
                Swal.getCancelButton().setAttribute('disabled', '')
                var PIN = Swal.getPopup().querySelector('#pin').value
                var remarks = Swal.getPopup().querySelector('#remarks').value
                    $.post(WebURL + '/pin-check',{PIN:PIN},function(data){
                        if(data == 1)
                        {
                            $.post(WebURL + '/PEA-Approval-insert',{FiledID:FiledID,Type:0,remarks:remarks},function(data){
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

    $('#btnDisapprove').on('click' ,function(){
        swal.fire({
            title: 'Disapprove',
            showCancelButton: true,
            html: '<h5> Comment: </h5><textarea name="remarks" id="remarks" cols="30" rows="5" class="swal2-input" placeholder="Remarks..."> </textarea> <br> <h5> Enter PIN: </h5> <input type="password" id="pin" class="swal2-input" placeholder="####"  maxlength="4">',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Confirm',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm:(done) =>
            {
                return new Promise(function(resolve, reject) {
                Swal.getCancelButton().setAttribute('disabled', '')
                var PIN = Swal.getPopup().querySelector('#pin').value
                var remarks = Swal.getPopup().querySelector('#remarks').value
                    $.post(WebURL + '/pin-check',{PIN:PIN},function(data){
                        if(data == 1)
                        {
                            $.post(WebURL + '/PEA-disapprove',{FiledID:FiledID,remarks:remarks},function(data){
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

})
