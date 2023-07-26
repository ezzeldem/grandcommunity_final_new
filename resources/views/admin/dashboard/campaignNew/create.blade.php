@extends('admin.dashboard.layouts.app')
@section('title', 'Create Campaign')
@section('style')
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />
    <style>
        .branch_voucher {
            border: 1px solid #0c171d42;
            min-width: 40%;
            max-width: 80%;
            padding: 14px 0 0 2px;
            text-align: center;
            display: flex;
            justify-content: space-around;
            border-radius: 3px;
            margin-bottom: 5px;
        }


        body {
            overflow-x: hidden;
        }

        /* switch */
        .button-row-container {
            width: 250px;
            height: 50px;
            position: relative;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin: 20px auto 0;
            border: 1px solid #a6a6a6;
            padding: 1em;
        }

        .switch-container {
            display: inline-block;
            margin: 10px 10px;
            transform: scale(0.7);
        }

        input.voucher_switch {
            max-height: 0;
            max-width: 0;
            opacity: 0;
            position: absolute;
            left: -9999px;
            pointer-event: none;
        }

        input.voucher_switch+label {
            display: block;
            position: relative;
            box-shadow: inset 0 0 0px 1px #a6a6a6;
            text-indent: -5000px;
            height: 30px;
            width: 50px;
            border-radius: 15px;
        }

        input.voucher_switch+label:before {
            content: "";
            position: absolute;
            display: block;
            height: 30px;
            width: 30px;
            top: 0;
            left: 0;
            border-radius: 15px;
            background: transparent;
            -moz-transition: 0.2s ease-in-out;
            -webkit-transition: 0.2s ease-in-out;
            transition: 0.2s ease-in-out;
            cursor: pointer;

        }

        input.voucher_switch:checked+label:after {
            left: 20px;
            box-shadow: inset 0 0 0 1px #516bf1, 0 2px 4px rgb(0 0 0 / 20%);
        }

        input.voucher_switch+label:after {
            content: "";
            position: absolute;
            display: block;
            height: 30px;
            width: 30px;
            top: 0;
            left: 0px;
            border-radius: 15px;
            background: white;
            box-shadow: inset 0px 0px 0px 1px rgb(0 0 0 / 20%), 0 2px 4px rgb(0 0 0 / 20%);
            -moz-transition: 0.2s ease-in-out;
            -webkit-transition: 0.2s ease-in-out;
            transition: 0.2s ease-in-out;
            cursor: pointer;

        }

        input.voucher_switch:checked+label:before {
            width: 50px;
            background: #4068ff;
        }

        .btn_container {
            box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;
            border-radius: 9px;
            padding: 0rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-around;
            margin: 1rem 0.5rem;
        }

        .select2-search__field {
            width: 100% !important;
        }

        .btn_container .btn_label {
            text-transform: capitalize;
            font-weight: 600;
            letter-spacing: 2px;
            color: #fff;
        }

        #invalid_1 {
            margin-top: 20px;
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 29px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;

        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }

        .platform-item {
            background-color: #242121;
            padding: 10px
        }

        .platform-item h6 {
            color: var(--border-color) !important
        }

        .platform-item label {
            color: #fff !important;
            font-size: 14px;
        }

        .platform-item input[type='checkbox'] {
            accent-color: var(--border-color) !important;
        }

        .platform-item-check {
            display: flex;
            justify-content: space-between;
            align-items: start;
            flex-direction: row
        }

        .main_platform h2 {
            color: #fff;
            font-size: 16px;
            margin-bottom: 15px
        }
    </style>
@stop
@section('content')
    @php
        $routes = [['route' => route('dashboard.campaigns.index'), 'name' => 'Campaigns']];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb', $routes)
    <div class="row gutters">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mg-b-0">@yield('title')</h4>
                    </div>
                </div>
                <div class="card-body">
                    {{--                @if ($errors->any()) --}}
                    {{--                    <div class="row "> --}}
                    {{--                        @foreach ($errors->all() as $error) --}}
                    {{--                            <div class="col-md-4 col-xs-12 ml-2 alert alert-danger alert-dismissible fade show" role="alert"> --}}
                    {{--                                <strong>{{$error}}!</strong> --}}
                    {{--                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> --}}
                    {{--                                    <span aria-hidden="true">&times;</span> --}}
                    {{--                                </button> --}}
                    {{--                            </div> --}}
                    {{--                        @endforeach --}}
                    {{--                    </div> --}}
                    {{--                @endif --}}

                    <form action="{{ route('dashboard.create-campaign.store') }}" method="POST"
                        enctype="multipart/form-data" data-parsley-validate="" novalidate="" id="campaign-form"
                        class="create_page">
                        @csrf
                        @include('admin.dashboard.campaignNew.form')
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="{{ asset('js/campaign/create.js') }}"></script>
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            var visit_start_date = $('input[name="visit_start_date"]'); //our date input has the name "date"
            var visit_end_date = $('input[name="visit_end_date"]'); //our date input has the name "date"
            var deliver_start_date = $('input[name="deliver_start_date"]'); //our date input has the name "date"
            var deliver_end_date = $('input[name="deliver_end_date"]'); //our date input has the name "date"

            var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
            var options = {
                format: 'yyyy-mm-dd ',
                container: container,
                todayHighlight: true,
                autoclose: true,
            };
            visit_start_date.datepicker(options);
            visit_end_date.datepicker(options);
            deliver_start_date.datepicker(options);
            deliver_end_date.datepicker(options);


        });

        $(document).on('click', '#has_voucher', function() {
            if (!$(this).is(":checked")) {
                $('.parent_prem_voucher').each(function(i, obj) {
                    $(this).prop('checked', false);
                });
                $('.parent_prem_voucher').parent().hide()
            } else {
                $('.parent_prem_voucher').parent().show()
            }
        })
        $(document).on('click', '.parent_prem_branch', function() {

            if (!$(this).is(":checked")) {
                $(this).parent('label').siblings('label').children('input').prop('disabled', true);
                $(this).parent('label').siblings('label').children('input').prop('checked', false)
            } else {
                $(this).parent('label').siblings('label').children('input').prop('disabled', false);
            }

        })
        $("#show_generate_pw").on('click', function() {
            $(".usercampaign_password_div").toggle('show');
        });

        // Handle objective Select 
        function showSocialPlatform(element) {
            var platform_name = 'display_' + element;
            ele = $('.' + platform_name);
            if (ele.css("display") == "none")
                $('.' + platform_name).css('display', 'block')
            else
                $('.' + platform_name).css('display', 'none')
        }


        function showToggleButton(elem) {
            var switchStatus = false;
            $(".customSwitch2").on('change', function() {
                if ($(this).is(':checked')) {
                    switchStatus = $(this).is(':checked');
                    $('.platform-items').css('display', 'block')
                } else {
                    switchStatus = $(this).is(':checked');
                    $('.platform-items').css('display', 'none');
                }
            });
            var datasle = elem.options[elem.selectedIndex].getAttribute('data-change');
            $('.custom-switch').css('display', 'none');
            $('.object_' + datasle).css('display', 'block');

        }

        function showShare(input, param) {
            
            if ($(input).is(':checked')) {
                $('.' + param).css('visibility', 'visible');
                $('.' + param).css('height', '100%');
                $('.' + param).css('opacity', '1');
                $('.' + param).css('padding', '1rem 0rem');
            } else {

                $('.' + param).css('visibility', 'hidden');
                $('.' + param).css('height', '0px');
                $('.' + param).css('opacity', '0');
                $('.' + param).css('padding', '0rem 0rem');
            }



        }
    </script>
@stop
