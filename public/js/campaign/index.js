$(document).ready(function(){
    // select all
    $('#exampleTbl input[name="select_all"]').click(function () {
        $('#exampleTbl td input:checkbox').prop('checked', this.checked);
    });


    //Clear check all after change page
    $('body').on('click', '.pagination a', function(e) {
        if($('#exampleTbl td input:checkbox').prop('checked') == true){
            $('#select_all').prop('checked',false);
        }
    });
})
function campaignStatus(status) {
    switch(status.value){
        case 0 :
            return `<span class="badge badge-pill status-active">${status.name}</span>`;
        case 1 :
            return `<span class="badge badge-pill status-active">${status.name}</span>`;
        case 2 :
            return `<span class="badge badge-pill status-pending">${status.name}</span>`;
        case 3 :
            return `<span class="badge badge-pill status-reject">${status.name}</span>`;
        case 4 :
            return `<span class="badge badge-pill status-pending">${status.name}</span>`;
        case 5 :
            return `<span class="badge badge-pill status-pending">${status.name}</span>`;
    }
}

function campaignTypes(type){

    switch(type){
        case 'Visit' :
            return `<span class="badge badge-pill status-active"> Visit </span>`;
        case 'Delivery' :
            return `<span class="badge badge-pill status-pending"> Delivery </span>`;
        case 'Mix' :
            return `<span class="badge badge-pill status-reject"> Mix </span>`;
        case 'Share' :
            return `<span class="badge badge-pill status-pending"> Share </span>`;
        case 'Post Creation' :
            return `<span class="badge badge-pill status-pending"> Post Creation </span>`;
    }
}

function isValidDate(d) {
    return !isNaN(Date.parse(d));
}

$('#filter').click(function (){
    if($('#filterSection').css('visibility') == 'visible'){
        $('#filterSection').css({'visibility':'hidden', 'height':0})
    }else{
        $('#filterSection').css({'visibility':'visible', 'height':'auto'})
    }
})

var start = '';
var end = '';
function cb(start, end) {
    $('#reportrange span').html( ( isValidDate(start) && isValidDate(end) ) ? start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY') : '');
    $('#startDateSearch').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
    $('#endDateSearch').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
}
$('#reportrange').daterangepicker({
    autoUpdateInput: false,
    "minYear": 2000,
    "maxYear": 2030,
    startDate: moment().subtract(29, 'days'),
    endDate: moment(),
    ranges: {
        'All': ['', ''],
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
    }
}, cb);
cb(start, end);
$("#reportrange").on('click', function (){
    start = moment().subtract(29, 'days');
    end = moment();
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $('#startDateSearch').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
    $('#endDateSearch').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
})

$('#country_id_search').select2({
    placeholder: "Select Country",
    allowClear: true
});

$('#campaign_status_search').select2({
    placeholder: "Select Campaign Status",
    allowClear: true
});

$('#campaign_type_search').select2({
    placeholder: "Select Campaign Type",
    allowClear: true
});

