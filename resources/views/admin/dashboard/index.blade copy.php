@extends('admin.dashboard.layouts.app')

@section('title', 'Home')

@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')
    <style>
        .card_statics_div {
            height: 200px !important;
            position: relative;
            overflow: hidden;
            width: auto;
            height: auto;
        }

        .info-stats3 {
            min-height: 72px !important;
        }

        .card_details .slimScrollDiv {
            height: 500px !important;
        }

        .card_details .customScroll5 {
            height: 500px !important;
        }
    </style>
@stop
@section('content')

    <div class="row gutters">
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('dashboard.influences.index') }}" title="Influencers">
                <div class="home_cards card p-4">
                    <div class="d-flex justify-content-center justify-content-center text-center flex-column mb-3">
                        <span class="home_cards_total font-weight mb-2"> {{ $stats['totalInfluencer'] }} </span>
                        <span class="home_cards_title font-weight-bold"> Influencers </span>
                    </div>
                    <ul class="home_cards_list d-flex justify-content-around align-items-center flex-wrap mb-2">
                        <li> Active: <span> {{ $stats['totalInfluencer'] }} </span> </li>
                        <li> Inactive: <span> {{ $stats['inactiveInfluencer'] }}</span> </li>
                        <li> Pending: <span> {{ $stats['pendingInfluencer'] }} </span> </li>
                        <li> Rejected: <span> {{ $stats['rejectedInfluencer'] }} </span> </li>
                    </ul>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('dashboard.brands.index') }}" title="brands">
                <div class="home_cards card p-4">
                    <div class="d-flex justify-content-center justify-content-center text-center flex-column mb-3">
                        <span class="home_cards_total font-weight mb-2"> {{ $stats['totalBrand'] }} </span>
                        <span class="home_cards_title font-weight-bold"> Brands </span>
                    </div>
                    <ul class="home_cards_list d-flex justify-content-around align-items-center flex-wrap mb-2">
                        <li> Active: <span> {{ $stats['activeBrand'] }} </span> </li>
                        <li> Inactive: <span> {{ $stats['inactiveBrand'] }}</span> </li>
                        <li> Pending: <span> {{ $stats['pendingBrand'] }} </span> </li>
                        <li> Rejected: <span> {{ $stats['rejectedBrand'] }} </span> </li>
                    </ul>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('dashboard.campaigns.index') }}" title="Campaigns">
                <div class="home_cards card p-4">
                    <div class="d-flex justify-content-center justify-content-center text-center flex-column mb-3">
                        <span class="home_cards_total font-weight mb-2"> {{ $stats['totalCamp'] }} </span>
                        <span class="home_cards_title font-weight-bold"> Campaigns </span>
                    </div>
                    <div class="dropdown-menu"
                        style="position: absolute; transform: translate3d(113px, 0px, 0px); top: 0px;left: 0px;will-change: transform;background: #1a233a;">
                        <ul>
                            @if (count($stats['totalFilters']) > 0)
                                @foreach ($stats['totalFilters'] as $key => $value)
                                    <li style="border: none;border-bottom: 1px solid #596280;" class="form-control">
                                        {{ $key }} : {{ $value }}</li>
                                @endforeach
                            @else
                                <li class="form-control">No Campaigns</li>
                            @endif
                        </ul>
                    </div>
                    <ul class="home_cards_list d-flex justify-content-unset align-items-start flex-wrap mb-2">
                        <li> Visit: <span> {{ $stats['visitCamp'] }} </span> </li>
                        <li> Delivery: <span> {{ $stats['deliveryCamp'] }}</span> </li>
                        <li> Mixed: <span> {{ $stats['mixCamp'] }} </span> </li>
                    </ul>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('dashboard.operations.index') }}" title="Operations">
                <div
                    class="home_cards_sec card d-flex justify-content-center justify-content-center text-center flex-column">
                    <span class="home_cards_total font-weight mb-2"> {{ $stats['totalOperations'] }} </span>
                    <span class="home_cards_title font-weight-bold"> Operations </span>
                </div>
            </a>
            <a href="{{ route('dashboard.sales.index') }}" title="Sales">
                <div
                    class="home_cards_sec card d-flex justify-content-center justify-content-center text-center flex-column mb-3">
                    <span class="home_cards_total font-weight mb-2"> {{ $stats['totalSales'] }} </span>
                    <span class="home_cards_title font-weight-bold"> Sales </span>
                </div>
            </a>
        </div>
    </div>

    <!----=================================== campaign chart================================== ---->
    {{-- <div id="buttons_filter_charts">
        <div class="d-flex justify-content-start align-items-start gap-4 flex-wrap">
            <button value="0" class="status_campagin btn hvr-sweep-to-right active" > Active </button>
            <button value="1" class="status_campagin btn hvr-sweep-to-right"> On Hold </button>
            <button value="2" class="status_campagin btn hvr-sweep-to-right"> Cancelled </button>
            <button value="3" class="status_campagin btn hvr-sweep-to-right"> Upcoming </button>
            <button value="4" class="status_campagin btn hvr-sweep-to-right"> Compeleted </button>
        </div>
    </div> --}}

    <div class="card">
        <div class="row">
            <div class="col-sm-6 choose_date">
                <label for=""> Date </label>
                <div id="start_and_end_date" class="form-control" style="height:42px">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
            <div class="col-sm-6 choose_date">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Status</label>
                    <select class="form-control select2 status_campagin" id="exampleFormControlSelect1" style="height:42px">
                        <option value="0" class="status_campagin">Active</option>
                        <option value="1" class="status_campagin">On Hold</option>
                        <option value="2" class="status_campagin">Cancelled</option>
                        <option value="3" class="status_campagin">Upcoming</option>
                        <option value="4" class="status_campagin">Compeleted</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="chart_section card p-3">
        <h3 class="" style="color: #fff">Campaign</h3>
        <div class="row">
            <div class="col-md-8">
                <canvas id="campaign-chart"></canvas>
            </div>
            <div class="col-md-4">
                <div style="background-color:#181818;">
                    <div class="card-body card_details">
                        <div class="browser-stats-container">
                            <div class="browser-stats Header_data_chart">
                                <div class="browser-icon Header_data_chart_title"> Country </div>
                                <div class="total text-success Header_data_chart_title">Visit</div>
                                <div class="total text-success Header_data_chart_title">Delivery</div>
                                <div class="growth text-success Header_data_chart_title">Mixed</div>
                            </div>
                        </div>
                        <div class="customScroll5">
                            <div class="browser-stats-container" id="all_campaigns_cards">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutters">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header d-flex justify-content-between align-items-start flex-wrap">
                    <div class="card-title">Active Campaign</div>
                    <a href="{{ route('dashboard.influences.index') }}?status=2"
                        class="btn seeMore Stop hvr-sweep-to-right">See More <i class="fa-solid fa-chevron-right"></i></a>
                </div>
                <div class="card-body" style="background-color:#181818;">
                    <div class="browser-stats-container">
                        <div class="browser-stats Header_data_chart Det_Camp">
                            <div class="browser-icon Header_data_chart_title"> Brand Name </div>
                            <div class="total text-success Header_data_chart_title">Campaign Name</div>
                            <div class="total text-success Header_data_chart_title">Date</div>
                            <div class="growth text-success Header_data_chart_title">Actions</div>
                        </div>
                    </div>
                    <div class="customScroll5">
                        <div class="browser-stats-container" id="active_campaigns">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <!-- Card start -->
            <div class="card p-3">
                <div class="card-header d-flex justify-content-between align-items-start flex-wrap">
                    <div class="card-title">Pending Campaign</div>
                    <a href="{{ route('dashboard.influences.index') }}?status=2"
                        class="btn seeMore Stop hvr-sweep-to-right">See More <i class="fa-solid fa-chevron-right"></i></a>
                </div>
                <div class="card-body" style="background-color:#181818;">
                    <div class="browser-stats Header_data_chart Det_Camp">
                        <div class="browser-icon Header_data_chart_title"> Brand Name </div>
                        <div class="total text-success Header_data_chart_title">Campaign Name</div>
                        <div class="total text-success Header_data_chart_title">Date</div>
                        <div class="growth text-success Header_data_chart_title">Actions</div>
                    </div>
                    <div class="customScroll5">
                        <div class="browser-stats-container" id="pending_campaigns">
                        </div>
                    </div>

                </div>
            </div>
            <!-- Card end -->
        </div>
    </div>

    <!--- =================================influencer charts ============================================================= -->
    <div class="chart_select card p-3">
        <div class="row">
            <div class="col-md-6">
                <label for="" class="d-block"> Status </label>
                <select class="bg-dark" id="InflueStatus" style="width: 100%">
                    <option value="" selected disabled>Select Status</option>
                    <option value="0">InActive</option>
                    <option value="1">Active</option>
                    <option value="2">Pending</option>
                    <option value="3">Rejected</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="" class="d-block"> Date </label>
                <div class="d-flex justify-content-start align-items-start">
                    <div id="start_end_influencer" class="form-control" style="height:42px">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span class="inputclear"></span> <i class="fa fa-caret-down"></i>
                    </div>
                    <button id="influencer_srch"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="chart_section card p-3">
        <h3 class="" style="color: #fff">Influencers</h3>
        <div class="row">
            <div class="col-md-8">
                <canvas id="influencer-chart"></canvas>
            </div>
            <div class="col-md-4">
                <div style="background-color:#181818;">
                    <div class="card-body card_details">
                        <div class="browser-stats-container">
                            <div class="browser-stats Header_data_chart">
                                <div class="browser-icon Header_data_chart_title"> Country </div>
                                <div class="total text-success Header_data_chart_title">Active</div>
                                <div class="total text-success Header_data_chart_title">Inactive</div>
                            </div>
                        </div>
                        <div class="customScroll5">
                            <div class="browser-stats-container" id="all_influencer_cards">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header">
            <h3 class="" style="color: #fff">New Influencers</h3>
        </div>
        <div class="card-body" style="background-color:#181818;">
            <div class="browser-stats-container">
                <div class="browser-stats Header_data_chart">
                    <div class="browser-icon Header_data_chart_title"> Influencer Name </div>
                    <div class="total text-success Header_data_chart_title">Country</div>
                    <div class="total text-success Header_data_chart_title">Date</div>
                    <div class="total text-success Header_data_chart_title">Actions</div>
                </div>
            </div>
            <div class="customScroll5">
                @foreach ($Newsinfluencers as $influencer)
                    <div class="browser-stats-container" id="influe_{{ $influencer->id }}">
                        <div class="browser-stats Header_data_chart Header_data_chart_info Det_Camp">
                            <div data-influe="{{ $influencer->id }}"
                                style="display: flex;
                        justify-content: space-between;
                        align-items: flex-start;
                        flex-direction: row;">
                                <div class="browser-icon _username_influncer" style="color:#fff !important;">
                                    {{ ($influencer->user) ? $influencer->user->user_name : '' }} </div>
                            </div>
                            <div class="browser-icon" style="color:#fff !important;"> <span class="_createdAt_table">
                                    {{ ucfirst($influencer->country->code ?? '') }} </span> </div>
                            <div class="browser-icon" style="color:#fff !important;"> <span class="_createdAt_table"> <i
                                        class="fas fa-calendar-week"></i> -
                                    {{ ($influencer->user) ? date('d-m-Y', strtotime($influencer->user->created_at)) : '' }} </span> </div>
                            <div class="total text-success"
                                style="display: flex;
                        justify-content: flex-start;
                        align-items: flex-start;
                        gap: 60px;">
                                <button id="{{ $influencer->id }}" value="0"
                                    class="Active hvr-sweep-to-right influencer_status">Active</button>
                                <button id="{{ $influencer->id }}" value="3"
                                    class="reject_influe influencer Delete hvr-sweep-to-right">Reject</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInfluencer" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Status</h4>
                </div>
                <div class="modal-body">
                    <h5>Are You Sure Rejected.</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="" value="" type="button"
                        class="influen_status btn btn-danger">submit</button>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalBrand" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Status</h4>
                </div>
                <div class="modal-body">
                    <h5>Are You Sure Rejected this Brand.</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="" value="" type="button"
                        class="brand_status btn btn-danger">submit</button>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalCampaign" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Status</h4>
                </div>
                <div class="modal-body">
                    <h5>Are You Sure Rejected.</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="" value="" type="button"
                        class="camp_status btn btn-danger">submit</button>
                </div>
            </div>

        </div>
    </div>
    <!-- ========================================================brand chart ============================================================= -->
    <div class="chart_select card p-3">
        <div class="row">
            <div class="col-md-6">
                <label for="" class="d-block"> Status </label>
                <select class="bg-dark" id="BrandStatus" style="width: 100%">
                    <option value="" selected disabled>Select Status</option>
                    <option value="0">InActive</option>
                    <option value="1">Active</option>
                    <option value="2">Pending</option>
                    <option value="3">Rejected</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="" class="d-block"> Date </label>
                <div class="d-flex justify-content-start align-items-start">
                    <div id="start_and_end_date_brand" class="form-control" style="height:42px">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span class="inputclear"></span> <i class="fa fa-caret-down"></i>
                    </div>
                    <button id="brand_srch"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="chart_section card p-3">
        <h3 class="" style="color: #fff">Brands</h3>
        <div class="row">
            <div class="col-md-8">
                <canvas id="brand-chart"></canvas>
            </div>
            <div class="col-md-4">
                <div style="background-color:#181818;">
                    <div class="card-body card_details">
                        <div class="browser-stats-container">
                            <div class="browser-stats Header_data_chart">
                                <div class="browser-icon Header_data_chart_title"> Country </div>
                                <div class="total text-success Header_data_chart_title">Active</div>
                                <div class="total text-success Header_data_chart_title">Inactive</div>
                            </div>
                        </div>
                        <div class="customScroll5">
                            <div class="browser-stats-container" id="all_brand_cards">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-3">
        <div class="card-header">
            <h3 class="" style="color: #fff">New Brands</h3>
        </div>
        <div class="card-body" style="background-color:#181818;">
            <div class="browser-stats-container">
                <div class="browser-stats Header_data_chart">
                    <div class="browser-icon Header_data_chart_title"> Brand Name </div>
                    <div class="total text-success Header_data_chart_title">Countries</div>
                    <div class="total text-success Header_data_chart_title">Date</div>
                    <div class="total text-success Header_data_chart_title">Actions</div>
                </div>
            </div>
            <div class="customScroll5">
                <div class="browser-stats-container">
                    @foreach ($NewsBrands as $new_brand)
                        <div class="brand_rem_{{$new_brand->id}}  browser-stats Header_data_chart Header_data_chart_info Det_Camp">
                            <div
                                style="display: flex;
                        justify-content: space-between;
                        align-items: flex-start;
                        flex-direction: row;">
                                <div class="browser-icon"><a style="color: #fff" class="_username_influncer"
                                        href="{{ route('dashboard.brands.show', $new_brand->id) }}">{{ $new_brand->user->user_name ?? '' }}
                                    </a></div>
                            </div>
                            <div>
                                <div
                                    style="display:flex;justify-content:flex-start;align-items:flex-start;gap:5px;flex-direction:row;flex-wrap:wrap">
                                    @foreach ($new_brand->countries->toArray() as $country)
                                        <p class="_count _username_influncer">
                                            {{ ucwords($country['code']) }}
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <span class="_createdAt_table"> <i class="fas fa-calendar-week"></i> -
                                    {{ date('d-M-y', strtotime($new_brand->created_at)) }} </span>

                            </div>
                            <div class=""
                                style="    display: flex;
                            justify-content: flex-start;
                            align-items: flex-start;
                            flex-direction: row;">
                                <button class="edit_brand_country hvr-sweep-to-right mr-2" value="{{ $new_brand->id }}"><i
                                        class="far fa-edit"></i> Active </button>
                                        <button class="reject_brand  hvr-sweep-to-right" value="3" id="{{ $new_brand->id }}"><i
                                            class="far fa-edit"></i> Reject </button>

                                </div>
                            </div>


                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== End brand chart ============================================================= -->


    <div class="row gutters">
        <div class="col-12">
            <!-- Card start -->

            <!-- Card end -->
        </div>
        {{-- @inject('influencer','App\Models\Influencer' )
        @php
        $influencers = $influencer->all();

        @endphp --}}
    </div>
    {{-- modal switch influencer Status --}}
    <div class="modal fade effect-newspaper show" id="influencer_data_switch" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Influencer Active
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="img_influ"></div>
                                <div class="mt-3 influencer_data_switch_data">
                                    <label class=""> Name : <span class="influencer_name"></span> </label>
                                    <div class="d-flex justify-content-center align-items-center flex-row gap-3">
                                        <label class="mr-4">Exprire Date :-</label>
                                        <input style="width: 100%" type="date" id="influencer_date"
                                            class="influencer_date">
                                    </div>
                                    <div>
                                        <label for=""> Influencer Id </label>
                                        <input id="influencer_id" type="hidden" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="button_switch_influencer_status"
                        class="btn Active hvr-sweep-to-right">Save</button>
                    <button type="button" class="btn Delete hvr-sweep-to-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal switch influencer Status --}}


    {{-- modal update Brand --}}
    <div class="modal fade effect-newspaper show" id="update_brand_data" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Edit Brand
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row mb-4">
                            <div class="col-sm-12 col-md-12">
                                <div class="influencer_data_switch_data">
                                    <span class="brand_img"> </span><label class="mr-4">Name :<span class="brand_name"> </span></label>
                                    <label class="">Countries : <select class="select2 col-md-10 bg-dark"style="" name=""id="brand_countries" multiple> <option value="" selected disabled>select</option></select> </label>
                                    <label class="mr-4">Expire Date : <input class="col-md-10" type="date" id="expire_date" name="expire_date"></label>
                                </div>
                                <input id="brand_id" type="hidden" value="">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="button_update_brand_country"
                        class="btn Active hvr-sweep-to-right">Save</button>
                    <button type="button" class="btn Delete hvr-sweep-to-right" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal update Brand --}}


    <!-- ======================================================== end brand chart ============================================================= -->
@endsection
@push('js')
    <script>
        $(document).ready(function() {




 $('body').on('click', '.reject_brand', function() {
$('#modalBrand').modal('show');
$('.brand_status').attr('id', $(this).attr('id'));
$('.brand_status').attr('value', $(this).attr('value'));
});

$('body').on('click', '.brand_status', function() {
        var status = $(this).attr('value');
        var $user = $(this).attr('id');
        $.ajax({
            url: `dashboard/brand-change_status`,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                status: status,
                brand_id: $user
            },
            success: function(response) {
                $('#modalBrand').modal('hide');
                Swal.fire("brand", `${response.brand.name} Rejected successfully`, "success");
                $('.brand_rem_'+response.brand.id).remove();

            }
        });
    });











            $('.select2').select2({

            });
            var log = console.log;
            $('.select2').select2({

            });
            $('.edit_brand_country').click(function() {
                var brand_id = $(this).val();
                let url = `/dashboard/get_brand_countries`;
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        brand_id: brand_id,
                    },
                    success: function(response) {
                        $('.brand_img').html('')
                        $('#brand_countries').html('');
                        var brand = response.brand;
                        var countries = response.countries;
                        for (i = 0; i < countries.length; i++) {
                            $('#brand_countries').append(new Option(countries[i].name,
                                countries[i].id));
                        }
                        $('.brand_name').html(brand.name);
                        $('.brand_img').append(
                            `<img src="${brand.image}" style="width:75px;height:75px">`);
                        var brand_id = $('#brand_id').val(brand.id);
                        $('#update_brand_data').modal('show');
                    }
                });

            })

            $('#button_update_brand_country').click(function() {
                var selected = [];
                for (var option of document.getElementById('brand_countries').options) {
                    if (option.selected) {
                        selected.push(option.value);
                    }
                }
                var expire_date =  $('#expire_date').val();
                var brand_id = $('#brand_id').val();
                $.ajax({
                    url: `/dashboard/update_brand_countries`,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        brand_id: brand_id,
                        country_id: selected,
                        expirations_date: expire_date,
                        status: 1,

                    },
                    success: function(response) {
                        console.log(response);
                        $('#update_brand_data').modal('hide');
                        $('.brand_rem_'+response.brand.id).remove();
                        Swal.fire("Updated!", "Change Country Successfully!", "success");
                    }
                });



            });
            var switchStatus = false;
            $(".switch_influencer_status").on('change', function() {
                $('.influencer_name').html('');
                var influe_id = $(this).val();
                if ($(this).is(':checked')) {
                    let url = `/dashboard/get_influencer_status`;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            influencer: influe_id
                        },
                        success: function(response) {
                            var influencer = response.data;
                            $('.influencer_name').html(influencer.name);
                            var inf_id = $('#influencer_id').val(influencer.id);
                            $('.img_influ').append(
                                `<img src="{{ asset('http://localhost:8000/assets/img/avatar_logo.png') }}">`
                            )
                            $('#influencer_data_switch').modal('show');
                        }
                    });
                }
            });


            $(".switch_influencer_status_reject").on('change', function() {
                var influe_id = $(this).val();
                if ($(this).is(':checked')) {
                    $.ajax({
                        url: `/dashboard/update_influencer_status`,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            influencer: influe_id,

                        },
                        success: function(response) {
                            var influe_id = response.id;

                            $(`#influe_${influe_id}`).remove();
                            Swal.fire("Updated!", "Change Status Successfully!", "success");
                        }
                    });
                }
            });

            $('#button_switch_influencer_status').on('click', function() {
                var inf_id = $('#influencer_id').val();
                var expir_date = $('#influencer_date').val();

                $.ajax({
                    url: `/dashboard/update_influencer_status`,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        influencer: inf_id,
                        exprie_date: expir_date,

                    },
                    success: function(response) {
                        $('#influencer_data_switch').modal('hide');
                        // var  influe_id =  response.id;
                        // $(`#influe_${influe_id}`).remove();
                        Swal.fire("Updated!", "Updated Successfully!", "success");
                    }
                });

            })

            var startDate;
            var endDate;
            $('#start_and_end_date').daterangepicker({
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
                    $('#start_and_end_date span').html(start.format('D MMMM YYYY') + ' - ' + end.format(
                        'D MMMM YYYY'));
                    startDate = start;
                    endDate = end;

                }
            );

            //Set the initial state of the picker label

$

            $('.status_campagin').on('change', function(e) {
                e.preventDefault();
                var status = $(this).attr('value');
                InitData({
                    "type": "campaign",
                    "status": status,
                    "start_date": startDate,
                    'end_date': endDate
                });
                console.log('activetap')
            });

            // Active class active to buttons filter charts
            // var btnContainer = document.getElementById("buttons_filter_charts");
            // var btns = btnContainer.getElementsByClassName("btn");
            // for (var i = 0; i < btns.length; i++) {
            //   btns[i].addEventListener("click", function() {
            //     var current = document.getElementsByClassName("active");
            //     if (current.length > 0) {
            //       current[0].className = current[0].className.replace(" active", "");
            //     }
            //     this.className += " active";
            //   });
            // }

        });
    </script>
    @include('admin.dashboard.layouts.includes.general.scripts.index')
    @include('admin.dashboard.layouts.includes.general.scripts.charts_script')
@endpush
