<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    var InitData = function(data) {

        $.ajax({
            type: 'POST',
            url: '{{ route('dashboard.get-charts-data') }}',
            data: JSON.stringify(data),
            contentType: 'application/json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                if (response.type == "campaign")
                    drawCampaigns(response.result);
                else if (response.type == "Influencer")
                    drawInfluencers(response.result);
                else if (response.type == "brand")
                    drawBrands(response.result);

            },
            error: function(x) {},
            complete: function(data) {}
        });
    }


    var initBarCampaignChartJS = function(data) {
        //  $("#lineSalonChart").html('').html('<canvas id="myChart" class="js-chartjs-lines"></canvas>');
        var ctx = document.getElementById('campaign-chart').getContext('2d');
        var chartExist = Chart.getChart("campaign-chart"); // <canvas> id
        if (chartExist != undefined) {
            chartExist.destroy();
        }
        var config = {
            labels: data.country_names,
            datasets: [{
                label: "Visit",
                fill: !0,
                backgroundColor: "#9B7029",
                borderColor: "#9B7029",
                pointBackgroundColor: "#9B7029",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "#9B7029",
                data: data.visit_count,
                barPercentage: 0.8,
                barThickness: 12,
                maxBarThickness: 15,
                minBarLength: 2,

            }, {
                label: "Mixed",
                fill: !0,
                backgroundColor: "#56401D",
                borderColor: "#56401D",
                pointBackgroundColor: "#56401D",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "#56401D",
                data: data.mix_count,
                barPercentage: 0.8,
                barThickness: 12,
                maxBarThickness: 15,
                minBarLength: 2,

            }, {
                label: "Delivery",
                fill: !0,
                backgroundColor: "#7F7F7F",
                borderColor: "#7F7F7F",
                pointBackgroundColor: "#7F7F7F",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "#7F7F7F",
                data: data.delivery_count,
                barPercentage: 0.8,
                barThickness: 12,
                maxBarThickness: 15,
                minBarLength: 2,

            }, {
                label: "Share",
                fill: !0,
                backgroundColor: "#1e8e8e",
                borderColor: "#1e8e8e",
                pointBackgroundColor: "#1e8e8e",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "#1e8e8e",
                data: data.share_count,
                barPercentage: 0.8,
                barThickness: 12,
                maxBarThickness: 15,
                minBarLength: 2,

            }, {
                label: "Post",
                fill: !0,
                backgroundColor: "#4C4D78FF",
                borderColor: "#4C4D78FF",
                pointBackgroundColor: "#4C4D78FF",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "#4C4D78FF",
                data: data.post_count,
                barPercentage: 0.8,
                barThickness: 12,
                maxBarThickness: 15,
                minBarLength: 2,

            }, ]
        };
        var chart_option = {
            title: {
                text: 'Campaign Statistics',
                display: true,
                fontColor: "white"
            },
            legend: {
                display: true,
                position: 'top'
            },
            date: {},
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#fff'
                    },
                    grid: {
                        display: false,
                        color: '#fff'
                    },
                    fontColor: "#ffffff"
                },
                x: {
                    ticks: {
                        color: '#fff'
                    },
                    grid: {
                        display: false,
                        color: '#fff',
                    },
                }
            }
        };

        dashChartLines = new Chart(ctx, {
            type: "bar",
            data: config,
            options: chart_option
        });
        dashChartLines.render();
    }


    var initInfluencerChartJS = function(data) {
        var influ_ctx = document.getElementById('influencer-chart').getContext('2d');
        var chartInfluExist = Chart.getChart("influencer-chart"); // <canvas> id
        if (chartInfluExist != undefined) {
            chartInfluExist.destroy();
        }

        var config = {
            labels: data.country_names,
            datasets: [{
                label: "Active",
                fill: !0,
                data: data.active_count,
                backgroundColor: "#3B7F34",

            }, {
                label: "InActive",
                fill: !0,
                data: data.inactive_count,
                backgroundColor: "#C52929",

            }]
        };
        var chart_option = {
            title: {
                text: 'Influencer Statistics',
                display: true,
                fontColor: "white"
            },
            legend: {
                display: true
            },
            date: {},
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    fontColor: "white"

                }
            }
        };

        dashChartLines = new Chart(influ_ctx, {
            type: "line",
            data: config,
            options: chart_option
        });
        dashChartLines.render();
    }


    var initBrandChartJS = function(data) {
        var brand_ctx = document.getElementById('brand-chart').getContext('2d');
        var chartExist = Chart.getChart("brand-chart"); // <canvas> id
        if (chartExist != undefined) {
            chartExist.destroy();
        }
        var config = {
            labels: data.country_names,
            datasets: [{
                fill: !0,
                label: "Active",
                data: data.active_count,
                backgroundColor: "#3B7F34",
            }, {
                label: "InActive",
                fill: !0,
                data: data.inactive_count,
                backgroundColor: "#C52929",

            }]
        };
        var chart_option = {
            title: {
                text: 'Brand Statistics',
                display: true,
                fontColor: "white"
            },
            legend: {
                display: true
            },
            date: {},
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    fontColor: "white"

                }
            }
        };

        dashChartLines = new Chart(brand_ctx, {
            type: "line",
            data: config,
            options: chart_option
        });
        dashChartLines.render();
    }


    function drawCampaigns(data) {
        $("#all_campaigns_cards").html('');
        var country_names = [];
        visit_count_arr = [];
        delivery_count_arr = [];
        mix_count_arr = [];
        share_count_arr = [];
        result = {};
        $.each(data.all_data, function(re_key, re_cards) {
            country_names.push(re_key);
            visit_count_arr.push(re_cards.visit_count);
            delivery_count_arr.push(re_cards.delivery_count);
            mix_count_arr.push(re_cards.mix_count);
            share_count_arr.push(re_cards.share_count);
            // $("#all_campaigns_cards").append(
            //     '<div class="browser-stats Header_data_chart  Header_data_chart_info"> <div class="browser-icon"> ' +
            //     re_key + ' </div>  <div class="total" >' + re_cards.visit_count +
            //     '</div> <div class="total" >' + re_cards.delivery_count + '</div> <div class="total" >' +
            //     re_cards.mix_count + '</div> <div class="total" >' +
            //     re_cards.share_count + '</div> </div> ');
            $("#all_campaigns_cards").append(
                '<div class="browser-stats Header_data_chart  Header_data_chart_info"> <div class="browser-icon"> ' +
                re_key + '</div><div class="total">' + (Number(re_cards.visit_count) + Number(re_cards.delivery_count) + Number(re_cards.mix_count) + Number(re_cards.share_count) + Number(re_cards.post_count)) +
                '</div> </div>');
        });

        result = {
            'country_names': country_names,
            'visit_count': visit_count_arr,
            'delivery_count': delivery_count_arr,
            'mix_count': mix_count_arr,
            'share_count': share_count_arr
        };
        initBarCampaignChartJS(result);

    }

    function drawInfluencers(data) {
        $("#all_influencer_cards").html('');
        var country_names = [];
        active_count_arr = [];
        in_active_count_arr = [];
        result = {};
        $.each(data.all_data, function(re_key, re_cards) {
            country_names.push(re_key);
            active_count_arr.push(re_cards.active_count);
            delivery_count_arr.push(re_cards.in_active_count);
            $("#all_influencer_cards").append(
                '<div class="browser-stats Header_data_chart  Header_data_chart_info"> <div class="browser-icon"> ' +
                re_key + '</div> <div class="total" >' + re_cards.active_count +
                '</div><div class="total" >' + re_cards.in_active_count + '</div> </div>');
        });
        result = {
            'country_names': country_names,
            'active_count': active_count_arr,
            'inactive_count': in_active_count_arr
        };
        initInfluencerChartJS(result);
    }

    function drawBrands(data) {
        $("#all_brand_cards").html('');
        var country_names = [];
        active_count_arr = [];
        in_active_count_arr = [];
        result = {};
        $.each(data.all_data, function(re_key, re_cards) {
            country_names.push(re_key);
            active_count_arr.push(re_cards.active_count);
            delivery_count_arr.push(re_cards.in_active_count);
            $("#all_brand_cards").append(
                '<div class="browser-stats Header_data_chart Header_data_chart_info"> <div class="browser-icon"> ' +
                re_key + '</div> <div class="total" >' + re_cards.active_count +
                '</div><div class="total" >' + re_cards.in_active_count + '</div> </div');
        });
        result = {
            'country_names': country_names,
            'active_count': active_count_arr,
            'inactive_count': in_active_count_arr
        };
        initBrandChartJS(result);
    }

    function drawActivePandingCampaigns(result, divID) {
        var databind = '';
        if (divID == 'active_campaigns')
            databind =
            // '<button status="6" class="change_status_campa Stop hvr-sweep-to-right"><i class="fas fa-record-vinyl"></i> Stop Visit</button><button status="5" class="change_status_campa Hold hvr-sweep-to-right"><i class="fas fa-stop"></i>Hold</button>'
            '<button status="3" class="change_status_campa Delete hvr-sweep-to-right"><i class="fas fa-record-vinyl"></i> Cancel </button>'
        else
            databind =
            '<button status="0"  class="change_status_campa Active hvr-sweep-to-right">Active</button><button  value="3" class="reject_camp campaign Delete hvr-sweep-to-right">Reject camp</button>'

        $.each(result.data, function(key, value) {
            $("#" + divID).append(
                '<div id=' + value.id +
                ' class="browser-stats Header_data_chart Header_data_chart_info Det_Camp campaignAct" style="justify-content: flex-start" data-campaign="' +
                value.id + '"> <div class="browser-icon"> <span class="_username_influncer"> ' + value
                .name + ' </span> </div>  <div class="total" > <span class="_username_influncer"> ' + value
                .brand +
                ' </span> </div><div class="total" id=""> <span class="_createdAt_table"> <i class="fas fa-calendar-week"></i> - ' +
                value.start_date + ' </span>  </div > ' + databind + ' </div> ');
        });
    }

    function getActiveAndPendingCampaigns($status, divID) {
        $.ajax({
            type: 'Get',
            url: '{{ route('dashboard.campaigns.datatable') }}?status_val=' + $status,
            data: {},
            contentType: 'application/json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                drawActivePandingCampaigns(response, divID);
            },
            error: function(x) {},
            complete: function(data) {}
        });

        // $('#someScrollingDiv').on('scroll', function() {
        //     let div = $(this).get(0);
        //     if(div.scrollTop + div.clientHeight >= div.scrollHeight) {
        //         // do the lazy loading here
        //     }
        // });
    }
    $(document).ready(function() {
        InitData({
            "type": "campaign"
        });
        InitData({
            "type": "Influencer"
        });
        InitData({
            "type": "brand"
        });
        getActiveAndPendingCampaigns(0, "active_campaigns");
        getActiveAndPendingCampaigns(1, "pending_campaigns");

    });

    $(function() {
        $('#reportrange').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY/MM/DD'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                'MM/DD/YYYY'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });


    var startDateInflue;
    var endDateInflue;
    $(document).ready(function() {


        $('#start_end_influencer').daterangepicker({
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                minDate: '01/01/2020',
                maxDate: '12/31/2022',

                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,

                opens: 'center',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'DD/MM/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom Range',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    firstDay: 1
                }
            },


            function(start, end) {
                $('#start_end_influencer span').html(start.format('D MMMM YYYY') + ' - ' + end.format(
                    'D MMMM YYYY'));
                startDateInflue = start;
                endDateInflue = end;
            }


        );
        $('#influencer_srch').click(function() {
            var status = $('#InflueStatus').find(":selected").val();
            InitData({
                "type": "Influencer",
                "start_date": startDateInflue,
                'end_date': endDateInflue,
                "status": status
            });
        })



    });



    var startDateBrand;
    var endDateBrand;
    $(document).ready(function() {


        $('#start_and_end_date_brand').daterangepicker({
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                minDate: '01/01/2020',
                maxDate: '12/31/2022',

                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,

                opens: 'center',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'DD/MM/YYYY',
                separator: ' to ',
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    applyLabel: 'Submit',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom Range',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    firstDay: 1
                }
            },


            function(start, end) {
                $('#start_and_end_date_brand span').html(start.format('D MMMM YYYY') + ' - ' + end.format(
                    'D MMMM YYYY'));
                startDateBrand = start;
                endDateBrand = end;
            });




        $('#brand_srch').click(function() {
            var status = $('#BrandStatus').find(":selected").val();
            InitData({
                "type": "brand",
                "start_date": startDateBrand,
                'end_date': endDateBrand,
                "status": status
            });
        })

    });


    $('body').on('click', '.influencer_status', function() {
        var status = $(this).attr('value');
        var $user = $(this).attr('id');
        $.ajax({
            url: `dashboard/influencer-change_status`,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                status: status,
                influencer_id: $user
            },
            success: function(response) {
                $('#modalInfluencer').modal('hide');
                Swal.fire("influencer", `${response.influ.name} update successfully`, "success");
                $('#influe_' + response.influ.id).remove();
            }
        });
    })
    $('body').on('click', '.reject_influe', function() {

        $('#modalInfluencer').modal('show');
        $('.influen_status').attr('id', $(this).attr('id'));
        $('.influen_status').attr('value', $(this).attr('value'));
        $('#modalInfluencer').modal('show');
    });
    $('body').on('click', '.influen_status', function() {
        var status = $(this).attr('value');
        var $user = $(this).attr('id');
        $.ajax({
            url: `dashboard/influencer-change_status`,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                status: status,
                influencer_id: $user
            },
            success: function(response) {
                $('#modalInfluencer').modal('hide');
                Swal.fire("influencer", `${response.influ.name} Rejected successfully`, "success");
                $('#influe_' + response.influ.id).remove();
            }
        });
    });

    let $elem = '';
    $('body').on('click', '.reject_camp', function() {

        $elem = (this).closest('.Det_Camp').getAttribute('id');
        $('#modalCampaign').modal('show');
        status = $(this).attr('status')

    });

    $('body').on('click', '.camp_status', function() {
        var status = $(this).attr('value');
        $.ajax({
            url: `dashboard/campaign-change_status`,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                status: status,
                campaign_id: $elem
            },
            success: function(response) {
                $('#modalCampaign').modal('hide');
                Swal.fire("campaign", `${response.campaign.name} Rejected successfully`,
                    "success");
                $(`div[data-campaign^=${$elem}]`).hide();
                $('#modalCampaign').modal('hide');
            }
        });
    });


    $('body').on('click', '.change_status_campa', function() {
        $elem = (this).closest('.Det_Camp').getAttribute('id');
        status = $(this).attr('status');
        if($(this).html() == `<i class="fas fa-stop"></i>Un Hold` ){
            $(this).html(`<i class="fas fa-stop"></i>Hold`)
        }else if($(this).html()==`<i class="fas fa-stop"></i>Hold`){
            $(this).html(`<i class="fas fa-stop"></i>Un Hold`)
        }
        $.ajax({
            url: `dashboard/campaign-change_status`,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                status: status,
                campaign_id: $elem
            },
            success: function(response) {
                $('#modalCampaign').modal('hide');
                Swal.fire("campaign", `${response.campaign.name} Active successfully`, "success");
                $(`div[data-campaign^=${$elem}]`).hide();
                $('#modalCampaign').modal('hide');
            }
        });

    });
</script>
