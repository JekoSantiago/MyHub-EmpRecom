$(document).ready(function() {

    var tbl_probi = $('#tbl_probi').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        ajax      : {
            url: WebURL + '/probi-list',
            method: 'GET',
        },
        columns   :[
            {data:"EmpStatus"},
            {data:"DateHired"},
            {data:"EmployeeNo"},
            {data:"FullName"},
            {data:"Position"},
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

    });








//////
})
