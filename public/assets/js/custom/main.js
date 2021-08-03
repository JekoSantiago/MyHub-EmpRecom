$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

})

$(document).ready(function() {

    var interval = setInterval(function() {
        var momentNow = moment();
        $('#date-part').html(momentNow.format('MMMM DD YYYY') + ' '
                            + momentNow.format('dddd')
                             .substring(0,3).toUpperCase());
        $('#time-part').html(momentNow.format('hh:mm:ss A'));

    }, 100);

    $('#btn_logout').on('click', function(){
        $.session.clear();
    })



    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
    };

//     var $sidebar   = $("#sidebar-menu"),
//     $window    = $(window),
//     offset     = $sidebar.offset(),
//     topPadding = 55;

//     $window.scroll(function() {
//     if ($window.scrollTop() > offset.top) {
//         $sidebar.stop().animate({
//             marginTop: $window.scrollTop() - offset.top + topPadding
//         });
//     } else {
//         $sidebar.stop().animate({
//             marginTop: 0
//         });
//     }
// });

});
