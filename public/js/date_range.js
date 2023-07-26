$(document).ready(function (){
    // date range
    function isValidDate(d) {
        return !isNaN(Date.parse(d));
    }
    var start = '';
    var end = '';
    var start_2 = '';
    var end_2 = '';
    var start_3 = '';
    var end_3 = '';
    var start_4 = '';
    var end_4 = '';
    var start_5 = '';
    var end_5 = '';
    var start_6 = '';
    var end_6 = '';

    function cb(start, end) {
        $('#reportrange span').html( ( isValidDate(start) && isValidDate(end) ) ? start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY') : '');
        $('#startDateSearch').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearch').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    }
    function cb6(start, end) {
        $('#reportrangeallfilter span').html( ( isValidDate(start) && isValidDate(end) ) ? start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY') : '');
        $('#startDateSearchAll').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearchAll').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    }
    function cb2(start, end) {
        $('#reportrangeActive span').html( ( isValidDate(start) && isValidDate(end) ) ? start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY') : '');
        $('#startDateSearchActive').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearchActive').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    }
    function cb3(start, end) {
        $('#reportrangePending span').html( ( isValidDate(start) && isValidDate(end) ) ? start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY') : '');
        $('#startDateSearchPending').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearchPending').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    }
    function cb4(start, end) {
        $('#reportrangeBrand span').html( ( isValidDate(start) && isValidDate(end) ) ? start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY') : '');
        $('#startDateSearchBrand').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearchBrand').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    }
    function cb5(start, end) {
        $('#reportrangeInfluencer span').html( ( isValidDate(start) && isValidDate(end) ) ? start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY') : '');
        $('#startDateSearchInfluencer').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearchInfluencer').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    }

    $('#reportrangeallfilter').daterangepicker({
        autoUpdateInput: false,
        "minYear": 2000,
        "maxYear": 2030,
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        ranges: {
            'All': ['', ''],
            'Today': [moment(), moment().add(1, 'days')],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
        }
    }, cb6);
    $('#reportrangeBrand').daterangepicker({
        autoUpdateInput: false,
        "minYear": 2000,
        "maxYear": 2030,
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        ranges: {
            'All': ['', ''],
            'Today': [moment(), moment().add(1, 'days')],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
        }
    }, cb4);
    $('#reportrangeInfluencer').daterangepicker({
        autoUpdateInput: false,
        "minYear": 2000,
        "maxYear": 2030,
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        ranges: {
            'All': ['', ''],
            'Today': [moment(), moment().add(1, 'days')],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
        }
    }, cb5);
    $('#reportrangePending').daterangepicker({
        autoUpdateInput: false,
        "minYear": 2000,
        "maxYear": 2030,
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        ranges: {
            'All': ['', ''],
            'Today': [moment(), moment().add(1, 'days')],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
        }
    }, cb3);
    $('#reportrangeActive').daterangepicker({
        autoUpdateInput: false,
        "minYear": 2000,
        "maxYear": 2030,
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        ranges: {
            'All': ['', ''],
            'Today': [moment(), moment().add(1, 'days')],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
        }
    }, cb2);
    $('#reportrange').daterangepicker({
        autoUpdateInput: false,
        "minYear": 2000,
        "maxYear": 2030,
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        ranges: {
            'All': ['', ''],
            'Today': [moment(), moment().add(1, 'days')],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
        }
    }, cb);

    cb(start, end);
    cb2(start_2,end_2)
    cb3(start_3,end_3)
    cb4(start_4,end_4)
    cb5(start_5,end_5)
    cb6(start_6,end_6)

    $("#reportrangeallfilter").on('click', function (){
        start = moment().subtract(29, 'days');
        end = moment();
        $('#reportrangeallfilter span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#startDateSearchAll').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearchAll').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    })
    $("#reportrangeInfluencer").on('click', function (){
        start = moment().subtract(29, 'days');
        end = moment();
        $('#reportrangeInfluencer span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#startDateSearchInfluencer').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearchInfluencer').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    })
    $("#reportrangeBrand").on('click', function (){
        start = moment().subtract(29, 'days');
        end = moment();
        $('#reportrangeBrand span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#startDateSearchBrand').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearchBrand').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    })
    $("#reportrangePending").on('click', function (){
        start = moment().subtract(29, 'days');
        end = moment();
        $('#reportrangePending span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#startDateSearchPending').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearchPending').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    })
    $("#reportrangeActive").on('click', function (){
        start = moment().subtract(29, 'days');
        end = moment();
        $('#reportrangeActive span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#startDateSearchActive').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearchActive').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    })
    $("#reportrange").on('click', function (){
        start = moment().subtract(29, 'days');
        end = moment();
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#startDateSearch').val( isValidDate(start) ? start.format('YYYY-MM-DD') : '' );
        $('#endDateSearch').val( isValidDate(end)? end.format('YYYY-MM-DD') : '');
    })



});
