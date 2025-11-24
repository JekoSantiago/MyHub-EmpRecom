$(document).ready(function() {

    var disableComm;
    var hideComm;
    var FiledID = $('#FiledID').val();

    console.log(isApproved,ApproveType,isDisApp,Qremain,isHR,isAccepted);
    if(isApproved == 1 && Qremain <= 0  || isAccepted == 1)
    {
        $(".rad_1").attr('disabled',true);
        $(".rad_2").attr('disabled',true);
        $(".rad_3").attr('disabled',true);
        $(".rad_4").attr('disabled',true);
        $(".rad_5").attr('disabled',true);

        if(isDisApp == 1 && ApproveType == 0)
        {
            disableComm = 0
            $(".rad_1").attr('disabled',false);
            $(".rad_2").attr('disabled',false);
            $(".rad_3").attr('disabled',false);
            $(".rad_4").attr('disabled',true);
            $(".rad_5").attr('disabled',false);
        }

        if(ApproveType == 1)
        {
            disableComm = 1
            $("#PRA").attr('disabled',true);
            $("#SnE").attr('disabled',true);
            $("#SAR").attr('disabled',true);
            $("#recom_letter").attr('disabled',true);
            // $("#btnSaveEval").hide();
        }
        else if(ApproveType == 2)
        {
            disableComm = 0
            $("#PRA").attr('disabled',false);
            $("#SnE").attr('disabled',false);
            $("#SAR").attr('disabled',false);
            $("#recom_letter").attr('disabled',false);
            // $("#btnSaveEval").show();
        }
        else if(ApproveType == 3)
        {
            disableComm = 1
            $("#PRA").attr('disabled',true);
            $("#SnE").attr('disabled',true);
            $("#SAR").attr('disabled',true);
            $("#recom_letter").attr('disabled',true);
            // $("#btnSaveEval").hide();
        }
        hideComm = 0;

        console.log('X')
    }
    else
    {
        if (isHR==1)
        {
            $(".rad_1").attr('disabled',true);
            $(".rad_2").attr('disabled',true);
            $(".rad_3").attr('disabled',true);
            $(".rad_4").attr('disabled',false);
            $(".rad_5").attr('disabled',true);
            $(".m_comment").hide();
            $(".m_update").hide();
            $("#PRA").attr('disabled',true);
            $("#SnE").attr('disabled',true);
            $("#SAR").attr('disabled',true);
            $("#recom_letter").attr('disabled',true);
            // $("#btnSaveEval").hide();
            disableComm = 1;

        }
        else
        {
            if(isHRRated==1 && ApproveType == 0)
            {
                $(".rad_1").attr('disabled',false);
                $(".rad_2").attr('disabled',false);
                $(".rad_3").attr('disabled',false);
                $(".rad_4").attr('disabled',true);
                $(".rad_5").attr('disabled',false);
                disableComm = 0;
            }
            else
            {
                $(".rad_1").attr('disabled',true);
                $(".rad_2").attr('disabled',true);
                $(".rad_3").attr('disabled',true);
                $(".rad_4").attr('disabled',true);
                $(".rad_5").attr('disabled',true);
                 disableComm = 1;

            }

        }

        if(Qremain <= 0)
        {
            hideComm = 0;
        }
        else
        {
            hideComm = 1;
        }

        console.log(disableComm);

    }


    if(disableComm==1)
    {
        $('body').find('textarea').attr('disabled','disabled');
        $('#btnSaveEval').hide();
    }


    function rateScale()
    {
        var Average = $('#AvePoint').text()
        if (Average >= 90)
        {
            $('#r_1').css("background-color", "#88EF8C");
            $('#r_2').css("background-color", "");
            $('#r_3').css("background-color", "");
            $('#r_4').css("background-color", "");
        }
        else if(Average >= 80)
        {
            $('#r_1').css("background-color", "");
            $('#r_2').css("background-color", "#88ACEF");
            $('#r_3').css("background-color", "");
            $('#r_4').css("background-color", "");
        }
        else if(Average >= 70)
        {
            $('#r_1').css("background-color", "");
            $('#r_2').css("background-color", "");
            $('#r_3').css("background-color", "#FCF2A9");
            $('#r_4').css("background-color", "");
        }
        else
        {
            $('#r_1').css("background-color", "");
            $('#r_2').css("background-color", "");
            $('#r_3').css("background-color", "");
            $('#r_4').css("background-color", "#F56464");
        }

    }

    rateScale();

    var fact1check = ($('.rad_1').filter(':checked').length == 3) ? true:false
    var fact2check = ($('.rad_2').filter(':checked').length == 3) ? true:false
    var fact3check = ($('.rad_3').filter(':checked').length == 3) ? true:false
    var fact4check = ($('.rad_4').filter(':checked').length == 3) ? true:false
    var fact5check = ($('.rad_5').filter(':checked').length == 3) ? true:false


    $('.rad_1').on('change',function(){
        var checkcount = $('.rad_1').filter(':checked').length


        if(checkcount == 3)
        {

            formdata = $('#form_ratings').serialize() + '&FactorID=' + 1;
            if (fact1check == true)
            {
                $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                    if(data.num>=0)
                    {
                        console.log(data);//radlog
                        $('#AvePoint').text(data.ave);
                        rateScale();

                        if(data.ave > 79)
                        {
                            $('#recomForm').show();
                        }
                        else
                        {
                            $('#recomForm').hide();
                        }

                        if(data.qremain <= 0)
                        {
                            $('#com_1').show();
                        }
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
                $.post(WebURL + '/PEA-Rate-insert',formdata,function(data){
                    if(data.num>=0)
                    {
                        console.log(data);//radlog
                        $('#AvePoint').text(data.ave);
                        rateScale();
                        if(data.ave > 79)
                        {
                            $('#recomForm').show();
                        }
                        else
                        {
                            $('#recomForm').hide();
                        }
                        if(data.qremain <= 0)
                        {
                            $('#com_1').show();
                        }

                    }
                    else if(data.num==-1)
                    {
                        $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                            if(data.num>=0)
                            {
                                console.log(data);//radlog
                                $('#AvePoint').text(data.ave);
                                rateScale();
                                if(data.ave > 79)
                                {
                                    $('#recomForm').show();
                                }
                                else
                                {
                                    $('#recomForm').hide();
                                }
                                if(data.qremain <= 0)
                                {
                                    $('#com_1').show();
                                }
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
                            text: data.msg,
                            icon: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false,
                        });
                    }
                })
            }
        }
    })

    $('.rad_2').on('change',function(){
        var checkcount = $('.rad_2').filter(':checked').length


        if(checkcount == 3)
        {
            formdata = $('#form_ratings').serialize() + '&FactorID=' + 2;
            if (fact2check == true)
            {
                $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                    if(data.num>=0)
                    {
                        console.log(data);//radlog
                        $('#AvePoint').text(data.ave);
                        rateScale();
                        if(data.ave > 79)
                        {
                            $('#recomForm').show();
                        }
                        else
                        {
                            $('#recomForm').hide();
                        }
                        if(data.Qremain <= 0)
                        {
                            $('#com_1').show();
                        }
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
                $.post(WebURL + '/PEA-Rate-insert',formdata,function(data){
                    if(data.num>=0)
                    {
                        console.log(data);//radlog
                        $('#AvePoint').text(data.ave);
                        rateScale();
                        if(data.ave > 79)
                        {
                            $('#recomForm').show();
                        }
                        else
                        {
                            $('#recomForm').hide();
                        }
                        if(data.Qremain <= 0)
                        {
                            $('#com_1').show();
                        }
                    }
                    else if(data.num==-1)
                    {
                        $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                            if(data.num>=0)
                            {
                                console.log(data);//radlog
                                $('#AvePoint').text(data.ave);
                                rateScale();
                                if(data.ave > 79)
                                {
                                    $('#recomForm').show();
                                }
                                else
                                {
                                    $('#recomForm').hide();
                                }
                                if(data.Qremain <= 0)
                                {
                                    $('#com_1').show();
                                }
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
                            text: data.msg,
                            icon: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false,
                        });
                    }
                })
            }
        }
    })

    $('.rad_3').on('change',function(){
        var checkcount = $('.rad_3').filter(':checked').length


        if(checkcount == 3)
        {
            formdata = $('#form_ratings').serialize() + '&FactorID=' + 3;
            if (fact3check == true)
            {
                $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                    if(data.num>=0)
                    {
                        console.log(data);//radlog
                        $('#AvePoint').text(data.ave);
                        rateScale();
                        if(data.ave > 79)
                        {
                            $('#recomForm').show();
                        }
                        else
                        {
                            $('#recomForm').hide();
                        }
                        if(data.Qremain <= 0)
                        {
                            $('#com_1').show();
                        }
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
                $.post(WebURL + '/PEA-Rate-insert',formdata,function(data){
                    if(data.num>=0)
                    {
                        console.log(data);//radlog
                        $('#AvePoint').text(data.ave);
                        rateScale();
                        if(data.ave > 79)
                        {
                            $('#recomForm').show();
                        }
                        else
                        {
                            $('#recomForm').hide();
                        }
                        if(data.Qremain <= 0)
                        {
                            $('#com_1').show();
                        }
                    }
                    else if(data.num==-1)
                    {
                        $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                            if(data.num>=0)
                            {
                                console.log(data);//radlog
                                $('#AvePoint').text(data.ave);
                                rateScale();
                                if(data.ave > 79)
                                {
                                    $('#recomForm').show();
                                }
                                else
                                {
                                    $('#recomForm').hide();
                                }
                                if(data.Qremain <= 0)
                                {
                                    $('#com_1').show();
                                }
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
                            text: data.msg,
                            icon: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false,
                        });
                    }
                })
            }
        }
    })

    $('.rad_4').on('change',function(){
        var checkcount = $('.rad_4').filter(':checked').length


        if(checkcount == 3)
        {
            formdata = $('#form_ratings').serialize() + '&FactorID=' + 4;
            if (fact4check == true)
            {
                $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                    if(data.num>=0)
                    {
                        console.log(data);//radlog
                        $('#AvePoint').text(data.ave);
                        rateScale();
                        if(data.ave > 79)
                        {
                            $('#recomForm').show();
                        }
                        else
                        {
                            $('#recomForm').hide();
                        }
                        if(data.Qremain <= 0)
                        {
                            $('#com_1').show();
                        }
                    }
                    else if(data.num==-1)
                    {
                        $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                            if(data.num>=0)
                            {
                                console.log(data);//radlog
                                $('#AvePoint').text(data.ave);
                                rateScale();
                                if(data.ave > 79)
                                {
                                    $('#recomForm').show();
                                }
                                else
                                {
                                    $('#recomForm').hide();
                                }
                                if(data.Qremain <= 0)
                                {
                                    $('#com_1').show();
                                }
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
                $.post(WebURL + '/PEA-Rate-insert',formdata,function(data){
                    if(data.num>=0)
                    {
                        console.log(data);//radlog
                        $('#AvePoint').text(data.ave);
                        rateScale();
                        if(data.ave > 79)
                        {
                            $('#recomForm').show();
                        }
                        else
                        {
                            $('#recomForm').hide();
                        }
                        if(data.Qremain <= 0)
                        {
                            $('#com_1').show();
                        }
                    }
                    else if(data.num==-1)
                    {
                        $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                            if(data.num>=0)
                            {
                                console.log(data);//radlog
                                $('#AvePoint').text(data.ave);
                                rateScale();
                                if(data.ave > 79)
                                {
                                    $('#recomForm').show();
                                }
                                else
                                {
                                    $('#recomForm').hide();
                                }
                                if(data.Qremain <= 0)
                                {
                                    $('#com_1').show();
                                }
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
                            text: data.msg,
                            icon: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false,
                        });
                    }
                })
            }
        }
    })

    $('.rad_5').on('change',function(){
        var checkcount = $('.rad_5').filter(':checked').length


        if(checkcount == 3)
        {
            formdata = $('#form_ratings').serialize() + '&FactorID=' + 5;
            if (fact5check == true)
            {
                $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                    if(data.num>=0)
                    {
                        console.log(data);//radlog
                        $('#AvePoint').text(data.ave);
                        rateScale();
                        if(data.ave > 79)
                        {
                            $('#recomForm').show();
                        }
                        else
                        {
                            $('#recomForm').hide();
                        }
                        if(data.Qremain <= 0)
                        {
                            $('#com_1').show();
                        }
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
                $.post(WebURL + '/PEA-Rate-insert',formdata,function(data){
                    if(data.num>=0)
                    {
                        console.log(data);//radlog
                        $('#AvePoint').text(data.ave);
                        rateScale();
                        if(data.ave > 79)
                        {
                            $('#recomForm').show();
                        }
                        else
                        {
                            $('#recomForm').hide();
                        }
                        if(data.Qremain <= 0)
                        {
                            $('#com_1').show();
                        }
                    }
                    else if(data.num==-1)
                    {
                        $.post(WebURL + '/PEA-Rate-update',formdata,function(data){
                            if(data.num>=0)
                            {
                                console.log(data);//radlog
                                $('#AvePoint').text(data.ave);
                                rateScale();
                                if(data.ave > 79)
                                {
                                    $('#recomForm').show();
                                }
                                else
                                {
                                    $('#recomForm').hide();
                                }
                                if(data.Qremain <= 0)
                                {
                                    $('#com_1').show();
                                }
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
                            text: data.msg,
                            icon: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false,
                        });
                    }
                })
            }
        }
    })

    var hideID=[];
    var tbl_comment = $('#tbl_comment').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        searching: false,
        paging: false,
        info: false,
        ordering: false,
        ajax      : {
            url: WebURL + '/PEA-comment-get/'+FiledID,
            datatype: 'json',
            method: 'POST',
        },
        columns   :[
                {render:function(data,type,row)
                {
                    var icon = (row.EvalComment == null) ? '<a href="javascript:void(0)" class="text-info m_comment" id="com_'+row.Month_ID+'"> <i class="mdi mdi-24px mdi-comment-outline"></i> <a>' : '<a href="javascript:void(0)" class="text-info m_update"> <i class="mdi mdi-24px mdi-comment-processing-outline"></i> <a>'
                    if(isHR == 0 && disableComm == 0)
                    {
                        return  icon ;
                    }
                    else
                    {
                        return '';
                    }

                }},
                {data:"MonthDef"},
                {data:"EvalComment"},
                {data:"EvalFullName"},
                {data:"DateComment"}

        ],
        drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        },
        language: {
            emptyTable: 'No data available.',
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            processing:'<div class="text-center"><div class="spinner spinner-border"></div></div>'
        },
        createdRow: function (row, data, index){
            var nextID = parseInt(data.Month_ID) + 1
            if(data.Filed_ID == null)
            {
                hideID.push('com_'+nextID);
            }

        },
        initComplete:function()
        {
            console.log(hideID);
            if(hideComm == 1)
            {
                $('#com_1').hide();
            }
            hideID.forEach(com => {
                $('#'+com).hide();
            });

            hideID=[];

            console.log(hideID);

        },

    });

    $('body').on('click','.m_comment',function(){
        var data = tbl_comment.row( $(this).parents('tr') ).data();
        console.log(data);
        var MonthID = data['Month_ID'];
        var Title = data['MonthDef'];

        $('#modal_comment').modal('show');
        $('#btn_save_comment').show();
        $('#btn_edit_comment').hide();
        $('#title_comment').text(Title);

        $('#MonthID').val(MonthID);

    })

    $('body').on('click','.m_update',function(){
        var data = tbl_comment.row( $(this).parents('tr') ).data();
        console.log(data);
        var MonthID = data['Month_ID'];
        var Title = data['MonthDef'];
        var Comment = data['EvalComment'];
        var id = data['Comment_ID'];
        $('#modal_comment').modal('show');
        $('#btn_edit_comment').show();
        $('#btn_save_comment').hide();
        $('#title_comment').text(Title);
        $('#MonthID').val(MonthID);
        $('#monthly_comment').val(Comment);
        $('#CommentID').val(id);

    })

    $('#btn_save_comment').on('click',function(){
        var error = false;
        var comment = $('#monthly_comment').val();

        if (comment.length <= 0)
        {
            error = true;
            $('#monthly_comment').addClass('error-input');
            $('#monthly_comment_error').show();
        }
        else
        {
            $('#monthly_comment').removeClass('error-input');
            $('#monthly_comment_error').hide();
        }

        if(error == false)
        {
            var formdata = $('#form_comment').serialize();
            swal.fire({
                title: 'Are you sure?',
                text: "Submitting the comment",
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
                    $.post(WebURL + '/PEA-comment-insert',formdata,function(data){
                    if(data.num>=0)
                        {
                            swal.fire({
                                title: 'Success',
                                text: data.msg,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                                }).then(function (result) {
                                    if (true) {
                                        $('#modal_comment').modal('hide');
                                        hideID=[];
                                        tbl_comment.ajax.reload( function(){
                                            hideID.forEach(com => {
                                                console.log(hideID);
                                                $('#'+com).hide();
                                            });
                                        }, false );
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

    $('#btn_edit_comment').on('click',function(){
        var error = false;
        var comment = $('#monthly_comment').val();

        if (comment.length <= 0)
        {
            error = true;
            $('#monthly_comment').addClass('error-input');
            $('#monthly_comment_error').show();
        }
        else
        {
            $('#monthly_comment').removeClass('error-input');
            $('#monthly_comment_error').hide();
        }

        if(error == false)
        {
            var formdata = $('#form_comment').serialize();
            swal.fire({
                title: 'Are you sure?',
                text: "Updating the comment",
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
                    $.post(WebURL + '/PEA-comment-update',formdata,function(data){
                    if(data.num>=0)
                        {
                            swal.fire({
                                title: 'Success',
                                text: data.msg,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                                }).then(function (result) {
                                    if (true) {
                                        $('#modal_comment').modal('hide');
                                        hideID=[];
                                        tbl_comment.ajax.reload( function(){
                                            console.log(hideID);
                                            hideID.forEach(com => {
                                                $('#'+com).hide();
                                            });
                                        }, false );
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


    $('#modal_comment').on('hidden.bs.modal', function () {
        $('#monthly_comment').val('');
    });


    $('#btnSaveEval').on('click',function(){
        var error = false;
        var pra = $('#PRA').val();
        var sne = $('#SnE').val();
        var sar = $('#SAR').val();

        if($('#recomForm').is(":visible"))
        {
            var recom = $('#recom_letter').val();
            if (recom.length <= 0)
            {
                error = true;
                $('#recom_letter').addClass('error-input');
                $('#recom_letter_error').show();
            }
            else
            {
                $('#recom_letter').removeClass('error-input');
                $('#recom_letter_error').hide();
            }
        }

        if (pra.length <= 0)
        {
            error = true;
            $('#PRA').addClass('error-input');
            $('#PRA_error').show();
        }
        else
        {
            $('#PRA').removeClass('error-input');
            $('#PRA_error').hide();
        }

        if (sne.length <= 0)
        {
            error = true;
            $('#SnE').addClass('error-input');
            $('#SnE_error').show();
        }
        else
        {
            $('#SnE').removeClass('error-input');
            $('#SnE_error').hide();
        }

        if (sar.length <= 0)
        {
            error = true;
            $('#SAR').addClass('error-input');
            $('#SAR_error').show();
        }
        else
        {
            $('#SAR').removeClass('error-input');
            $('#SAR_error').hide();
        }

        if(error == false)
        {
            var formdata = $('#form_emp_profile').serialize();
            swal.fire({
                title: 'Are you sure?',
                text: "Saving the evaluation",
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
                    $.post(WebURL + '/PEA-recom-update',formdata,function(data){
                    if(data.num>=0)
                        {
                            swal.fire({
                                title: 'Success',
                                text: data.msg,
                                icon: 'success',
                                confirmButtonText: 'Ok'
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




////
})



