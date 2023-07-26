
@extends('admin.dashboard.layouts.app')

@section('title','Home')

@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')
    <style>
        .campChartDataParent .campChartData{
            background: #0c1425;
            padding: 15px 5px;
            border-radius: 2px;
            display: flex;
            justify-content: space-around;
            font-weight: bold;
        }

        #exampleTblInfluencers tbody tr td a{
            color: #bcd0f7;
        }

        .inputs #reportrangeallfilter,#reportrangeInfluencer,#reportrangeBrand,#reportrangePending,#reportrangeActive
        {
            border: 1px solid #A27929 !important;
            height: 40px !important;
            line-height: 2 !important;
            /* margin-top: 4px !important; */
        }

        .disabledbutton {
            pointer-events: none;
            opacity: 0.4;
        }

        .uncompleted{
            background:#0e0e0e !important;
        }

        .viewButtonDiv{
            display: flex;
            margin: 0rem 1rem 0rem 0rem;
            align-items: center;
            z-index: 9999999;

            position: relative;
        }

        .viewButton{
            background-color: #1d1d1d !important;

        }
    </style>
@stop
@section('content')
    <div class="row gutters">
        <div class="col-sm-12 col-12">
            <div class="card">
                <h3 style="font-size: 20px;margin-top: 10px;text-align: center;margin-bottom: 0;text-transform: uppercase;letter-spacing: 2px;">General Filter</h3>
                <div class="card-header">
                    <div class="inputs mt-2 filter-date-home">
                        <div id="reportrangeallfilter" class="form-control">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                            <input type="hidden" value="startDateSearchAll" id="startDateSearchAll" name="startDateSearchAll">
                            <input type="hidden" value="endDateSearchAll" id="endDateSearchAll" name="endDateSearchAll">
                        </div>
                        <button class="btn" id="go_search"><i class="fa fa-search-plus"></i> Search</button>
                        <button class="btn" type="button" id="FilterResetButton"><i class="fa fa-filter"></i> Reset</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="inputs mb-2">
                        <label>Country</label>
                        <select style="border: 1px solid #a27929;" class="form-control select2 " name="operaionSectionFilterCountry"  id="operaionSectionFilterCountry">
                            <option disabled selected>Select</option>
                            @foreach($countries_active as $country)
                                <option value={{$country->id}}> {{$country->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 firstAllCounts" style="cursor: pointer">
            <div class="card">
                <div class="card-header">
                    <div class="viewButtonDiv">
                        <div class="card-title col-10">Operational Employees</div>
                        <a href="{{route('dashboard.operations.index')}}" class="btn viewButton float-right">View</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
                        <div class="customScroll5" style="overflow: hidden; width: auto; height: 250px;">
                            <ul class="statistics firstStats">
                                <li>
                                    <span class="stat-icon bg-info">
                                        <i class="icon-eye1"></i>
                                    </span>
                                    Total : {{$stats['totalOperations']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-success">
                                        <i class="icon-toggle-right"></i>
                                    </span>
                                    Active: {{$stats['activeOperations']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-danger">
                                        <i class="icon-toggle-left"></i>
                                    </span>
                                    Inactive : {{$stats['inactiveOperations']}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 secondAllCounts" style="cursor: pointer">
            <div class="card">
                <div class="card-header">
                    <div class="viewButtonDiv">
                        <div class="card-title col-10 mr-2">Influencers</div>
                        <a href="{{route('dashboard.influences.index')}}" class="btn viewButton float-right">View</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;"><div class="customScroll5" style="overflow: hidden; width: auto; height: 250px;">
                            <ul class="statistics secondStats">
                                <li>
                                    <span class="stat-icon bg-info">
                                        <i class="icon-eye1"></i>
                                    </span>
                                    Total : {{$stats['totalInfluencer']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-success">
                                        <i class="icon-toggle-right"></i>
                                    </span>
                                    Active: {{$stats['activeInfluencer']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-danger">
                                        <i class="icon-toggle-left"></i>
                                    </span>
                                    Inactive : {{$stats['inactiveInfluencer']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-info">
                                        <i class="icon-loader"></i>
                                    </span>
                                    Pending : {{$stats['pendingInfluencer']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-warning">
                                        <i class="icon-x-circle"></i>
                                    </span>
                                    Rejected : {{$stats['rejectedInfluencer']}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 thirdAllCounts" style="cursor: pointer">
            <div class="card">
                <div class="card-header">
                    <div class="viewButtonDiv">
                        <div class="card-title col-10">Brands</div>
                        <a href="{{route('dashboard.brands.index')}}" class="btn viewButton float-right">View</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;"><div class="customScroll5" style="overflow: hidden; width: auto; height: 250px;">
                            <ul class="statistics thirdStats">
                                <li>
                                    <span class="stat-icon bg-info">
                                        <i class="icon-eye1"></i>
                                    </span>
                                    Total : {{$stats['totalBrand']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-success">
                                        <i class="icon-toggle-right"></i>
                                    </span>
                                    Active: {{$stats['activeBrand']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-danger">
                                        <i class="icon-toggle-left"></i>
                                    </span>
                                    Inactive : {{$stats['inactiveBrand']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-info">
                                        <i class="icon-loader"></i>
                                    </span>
                                    Pending : {{$stats['pendingBrand']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-warning">
                                        <i class="icon-x-circle"></i>
                                    </span>
                                    Rejected : {{$stats['rejectedBrand']}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 fourthAllCounts" style="cursor: pointer">
            <div class="card">
                <div class="card-header">
                    <div class="viewButtonDiv">
                        <div class="card-title col-10">Campaigns</div>
                        <a href="{{route('dashboard.campaigns.index')}}" class="btn viewButton float-right viewButton">View</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;"><div class="customScroll5" style="overflow: hidden; width: auto; height: 250px;">
                            <ul class="statistics fourthStats">
                                <li>
                                    <div class="btn-group dropright">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="display: flex;align-items: center;justify-content: center;background: transparent;padding: 0">
                                           <span class="stat-icon bg-info" style="padding: 5px;margin-right: 11px; width: auto; height: auto;display: flex;align-items: center;justify-content: center;">
                                               <i class="icon-eye1" style="margin: 0 !important;padding: 5px;"></i>
                                           </span>
                                            Total: {{$stats['totalCamp']}}
                                        </button>
                                        <div class="dropdown-menu" style="position: absolute; transform: translate3d(113px, 0px, 0px); top: 0px;left: 0px;will-change: transform;background: #1a233a;">
                                            <ul>
                                                @if(count($stats['totalFilters']) > 0)
                                                    @foreach($stats['totalFilters'] as $key=>$value)
                                                        <li style="border: none;border-bottom: 1px solid #596280;" class="form-control">{{$key}} : {{$value}}</li>
                                                    @endforeach
                                                @else
                                                    <li class="form-control">No Campaigns</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <span class="stat-icon bg-success">
                                        <i class="icon-import_contacts"></i>
                                    </span>
                                    Visit : {{$stats['visitCamp']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-info">
                                        <i class="icon-local_airport"></i>
                                    </span>
                                    Delivery : {{$stats['deliveryCamp']}}
                                </li>
                                <li>
                                    <span class="stat-icon bg-warning">
                                        <i class="icon-swap_horiz"></i>
                                    </span>
                                    Mixed : {{$stats['mixCamp']}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gutters mb-3" id="parentCampaignDataAll">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Campaigns</h4>
                    </div>
                    <div class="inputs-campiagn-canvas mt-3" style="display: flex;align-items: center; justify-content: flex-start;gap: 10px">
                        <form id="CampaignFilterForm">
                            <div class="inputs mb-2">
                                <label>Country</label>
                                <select style="border: 1px solid #a27929;" class="form-control select2 " name="nationality" id="countryFilter">
                                    <option disabled selected> Select</option>
                                    @foreach($countries_active as $country)
                                        <option value={{$country->id}}> {{$country->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="inputs mb-2">
                                <label>Date</label>
                                <div id="reportrange" class="form-control">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                    <input type="hidden" value="startDateSearch" id="startDateSearch"  name="startDateSearch">
                                    <input type="hidden" value="endDateSearch" id="endDateSearch" name="endDateSearch">
                                </div>
                            </div>
                            <div class="inputs mb-2">
                                <button class="btn" type="submit" id="CampaignFilterSearchButton"><i class="fa fa-search-plus"></i> Search</button>
                                <button class="btn" type="button" id="CampaignFilterResetButton"><i class="fa fa-filter"></i> Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body b-p-apex">
                    <div class="sales-bar mt-4" style="min-height: 263px;">

                        <ul class="nav nav-tabs firstNavTabs" id="myTab" role="tablist" style="justify-content: space-around !important;">
                            <li class="nav-item">
                                <a class="nav-link selectCampaingTab active" id="active_visit_tab" data-status="0" data-type-camp="visit" data-camp-type-val="0" data-toggle="tab" href="#active_visit" role="tab" aria-controls="home" aria-selected="true">Active Visit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectCampaingTab" id="active_delivery_tab"  data-status="0" data-type-camp="delivery" data-camp-type-val="1" data-toggle="tab" href="#active_delivery" role="tab" aria-controls="profile" aria-selected="false">Active Delivery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectCampaingTab" id="active_mix_tab" data-status="0" data-type-camp="mix" data-camp-type-val="2" data-toggle="tab" href="#active_mix" role="tab" aria-controls="contact" aria-selected="false">Active Mixed</a>
                            </li>
                            {{----}}
                            <li class="nav-item">
                                <a class="nav-link selectCampaingTab" id="completed_visit_tab" data-status="2" data-type-camp="visit" data-camp-type-val="0"  data-toggle="tab" href="#completed_visit" role="tab" aria-controls="home" aria-selected="true">Completed Visit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectCampaingTab" id="completed_delivery_tab" data-status="2" data-type-camp="delivery" data-camp-type-val="1" data-toggle="tab" href="#completed_delivery" role="tab" aria-controls="profile" aria-selected="false">Completed Delivery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectCampaingTab" id="completed_mix_tab" data-status="2" data-type-camp="mix" data-camp-type-val="2" data-toggle="tab" href="#completed_mix" role="tab" aria-controls="contact" aria-selected="false">Completed Mixed</a>
                            </li>
                            {{----}}
                            <li class="nav-item">
                                <a class="nav-link selectCampaingTab" id="onhold_visit_tab" data-status="5" data-type-camp="visit" data-camp-type-val="0" data-toggle="tab" href="#onhold_visit" role="tab" aria-controls="home" aria-selected="true">On-Hold Visit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectCampaingTab" id="onhold_delivery_tab" data-status="5" data-type-camp="delivery" data-camp-type-val="1" data-toggle="tab" href="#onhold_delivery" role="tab" aria-controls="profile" aria-selected="false">On-Hold Delivery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectCampaingTab" id="onhold_mix_tab" data-status="5" data-type-camp="mix" data-camp-type-val="2" data-toggle="tab" data-status="5" data-type-camp="mix" data-camp-type-val="2" href="#onhold_mix" role="tab" aria-controls="contact" aria-selected="false">On-Hold Mixed</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="active_visit" role="tabpanel" aria-labelledby="home-tab">
                                Active Visit
                            </div>
                            <div class="tab-pane fade" id="active_delivery" role="tabpanel" aria-labelledby="profile-tab">
                                Active Delivery
                            </div>
                            <div class="tab-pane fade" id="active_mix" role="tabpanel" aria-labelledby="contact-tab">
                                Active Mixed
                            </div>
                            {{----}}
                            <div class="tab-pane fade" id="completed_visit" role="tabpanel" aria-labelledby="home-tab">
                                Completed Visit
                            </div>
                            <div class="tab-pane fade" id="completed_delivery" role="tabpanel" aria-labelledby="profile-tab">
                                Completed Delivery
                            </div>
                            <div class="tab-pane fade" id="completed_mix" role="tabpanel" aria-labelledby="contact-tab">
                                Completed Mixed
                            </div>
                            {{----}}
                            <div class="tab-pane fade" id="onhold_visit" role="tabpanel" aria-labelledby="home-tab">
                                On-Hold Visit
                            </div>
                            <div class="tab-pane fade" id="onhold_delivery" role="tabpanel" aria-labelledby="profile-tab">
                                On-Hold Delivery
                            </div>
                            <div class="tab-pane fade" id="onhold_mix" role="tabpanel" aria-labelledby="contact-tab">
                                On-Hold Mixed
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8" id="campaign-container" data-value="{{$campaignsChart}}" data-type="visit" data-status="active">
                                <canvas id="campaign-chart"></canvas>
                            </div>
                            <div class="col-md-4" id="campaign-container-data" data-value="{{$campaignsChart}}" data-type="visit" data-status="active">
                                <div class="campChartDataParent">
                                    @if(count($campaignsChart) > 0)
                                        @foreach($campaignsChart as $key=>$n)
                                            <div class="campChartData mb-2">
                                                <p>{{$key}}</p>
                                                @php
                                                    {{
                                                        $data = substr($n,1,-1);
                                                        $data = str_replace('"', " ", $data);
                                                    }}
                                                @endphp
                                                <p>{{$data}}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="campChartData mb-2">
                                            <p>There Are No Campaigns</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(count($campaignsPending) > 0)
            <div class="gutters col-lg-6 col-md-12 col-sm-12">
                <div>
                    <div class="table-container">
                        <div class="t-header">Pending Campaigns</div>
                        <table id="exampleTblPendingCamp" class="table custom-table resizable" >
                            <thead>
                            <tr>
                                {{--  <th><input name="select_all" id="select_all" type="checkbox" /></th>  --}}
                                    <th class="border-bottom-0">Campaign Name</th>
                                    <th class="border-bottom-0">Brand Name</th>
                                    <th class="border-bottom-0">Start Date</th>
                                    {{--  <th class="border-bottom-0">End Date</th>  --}}
                                    {{--  <th class="border-bottom-0">Country</th>  --}}
                                    <th class="border-bottom-0">Type</th>
                                    {{--  <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Daily</th>
                                    <th class="border-bottom-0">Total</th>  --}}
                                    {{--  <th class="border-bottom-0">Attendees</th>
                                    <th class="border-bottom-0">Secret Keys</th>  --}}
                                    {{--  <th class="border-bottom-0">Created At</th>  --}}
                                    @if(user_can_control('campaigns'))
                                        <th>Actions</th>
                                    @endif
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="col-md-4 col-sm-12">
                            <a href="{{route('dashboard.campaigns.index')}}?status_type=1" class="btn seeMore">See More</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(count($campaignsActive) > 0)
            <div class="gutters col-lg-6 col-md-12 col-sm-12">
                <div>
                    <div class="table-container">
                        <div class="t-header">Active Campaigns</div>
                        <table id="exampleTblActiveCamp" class="table custom-table resizable" >
                            <thead>
                            <tr>
                                {{--  <th><input name="select_all" id="select_all" type="checkbox" /></th>  --}}
                                    <th class="border-bottom-0">Campaign Name</th>
                                    <th class="border-bottom-0">Brand Name</th>
                                    <th class="border-bottom-0">Start Date</th>
                                    {{--  <th class="border-bottom-0">End Date</th>  --}}
                                    {{--  <th class="border-bottom-0">Country</th>  --}}
                                    <th class="border-bottom-0">Type</th>
                                    {{--  <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Daily</th>
                                    <th class="border-bottom-0">Total</th>  --}}
                                    {{--  <th class="border-bottom-0">Attendees</th>
                                    <th class="border-bottom-0">Secret Keys</th>  --}}
                                    {{--  <th class="border-bottom-0">Created At</th>  --}}
                                    @if(user_can_control('campaigns'))
                                        <th>Actions</th>
                                    @endif
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="col-md-4 col-sm-12">
                            <a href="{{route('dashboard.campaigns.index')}}?status_type=0" class="btn seeMore">See More</a>
                        </div>
                    </div>
                </div>
            </div>
            {{--  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-home">
                    <div class="card-header">
                        <div class="card-title mb-3">Active Campaings</div>
                        <div style="display: flex;
                        justify-content: flex-start;gap: 10px;">
                            <div id="reportrangeActive" class="form-control" style="width: 300px;">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                                <input type="hidden" value="startDateSearchActive" id="startDateSearchActive" name="startDateSearchActive">
                                <input type="hidden" value="endDateSearchActive" id="endDateSearchActive" name="endDateSearchActive">
                            </div>
                            <button id="activeCampsFilterDateBtn" class="btn "><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>

                     <div class="card-body">
                        <div class="customScroll5">
                            <div class="todo-container">
                                <ul class="todo-body ulActiveData">
                                    @foreach($campaignsActive as $active)
                                        <li class="todo-list">
                                            <div class="todo-info">
                                                <span class="dot blue"></span>
                                                <p>{{$active->name}}</p>
                                                <p class="mb-0 tx-13 text-muted">
                                                    {{$active->brand->name??'No Brand'}}
                                                    <span class="text-success ms-2">{{$active->getType() }}</span>
                                                </p>
                                                <p class="dt">{{\Carbon\Carbon::parse($active->updated_at)->format('H:i:a')}}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="slimScrollBar" style="background: rgba(39, 47, 71, 0); width: 5px; position: absolute; top: 42px; opacity: 0.8; display: block; border-radius: 0px; z-index: 99; right: 1px; height: 103.477px;"></div><div class="slimScrollRail" style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; background: rgba(39, 47, 71, 0); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                </div>

            </div>  --}}
        @endif
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 parentDataAll">
        <div class="card-group">
            <div class="card col-lg-6 col-md-12 col-sm-12 mr-2">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Brands</h4>
                    </div>
                    <div class="inputs-brand-canvas mt-3">
                        <form id="BrandFilterForm">
                            <div class="inputs mb-2">
                                <label>Country</label>
                                <select class="form-control select2 " name="countryFilterBrand"  id="countryFilterBrand">
                                    <option disabled selected> Select </option>
                                    @foreach($countries_active as $country)
                                        <option value={{$country->id}}> {{$country->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="inputs mb-2">
                                <label>Date</label>
                                <div id="reportrangeBrand" class="form-control">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                    <input type="hidden" value="startDateSearch" id="startDateSearchBrand" name="startDateSearchBrand">
                                    <input type="hidden" value="endDateSearch" id="endDateSearchBrand" name="endDateSearchBrand">
                                </div>
                            </div>
                            <div class="inputs mb-2">
                                <button class="btn" type="submit" id="BrandFilterSearchButton"><i class="fa fa-search-plus"></i> Search</button>
                                <button class="btn" type="button" id="BrandFilterResetButton"><i class="fa fa-filter"></i> Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body b-p-apex">
                    <div class="sales-bar mt-4" id="brand-container" data-value="{{$brandsChart}}" style="min-height:260px !important;">
                        <ul class="nav nav-tabs secondNavTabs"  style="justify-content: space-around !important;" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link selectBrandTab active" id="brand_active_tab" data-status="1" data-type-brand="active" data-toggle="tab" href="#brand_active_content" role="tab" aria-controls="home" aria-selected="true">Active</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectBrandTab" id="brand_inactive_tab" data-status="1" data-type-brand="active" data-toggle="tab" href="#brand_inactive_content" role="tab" aria-controls="profile" aria-selected="false">Inactive</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectBrandTab" id="brand_pending_tab" data-status="2" data-type-brand="pending" data-toggle="tab" href="#brand_pending_content" role="tab" aria-controls="contact" aria-selected="false">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectBrandTab" id="brand_reject_tab" data-status="3" data-type-brand="reject" data-toggle="tab" href="#brand_reject_content" role="tab" aria-controls="contact" aria-selected="false">Rejected</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="brand_active_content" role="tabpanel" aria-labelledby="home-tab">
                                Active Brands
                            </div>
                            <div class="tab-pane fade" id="brand_inactive_content" role="tabpanel" aria-labelledby="profile-tab">
                                Inactive Brands
                            </div>
                            <div class="tab-pane fade" id="brand_pending_content" role="tabpanel" aria-labelledby="contact-tab">
                                Pending Brands
                            </div>
                            <div class="tab-pane fade" id="brand_reject_content" role="tabpanel" aria-labelledby="contact-tab">
                                Pending Brands
                            </div>
                        </div>

                        <canvas id="brand-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="gutters col-lg-6 col-md-12 col-sm-12">
                <div>
                    <div class="table-container">
                        <div class="t-header">New Brands Users</div>
                        <table id="exampleTbl" class="table custom-table resizable" >
                            <thead>
                            <tr>
                                <th>name</th>
                                {{--                                <th>email</th>--}}
                                {{--                                <th>type</th>--}}
                                {{--                                <th>phone</th>--}}
                                {{--                                <th>Completed</th>--}}
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="col-md-4 col-sm-12">
                            <a href="{{route('dashboard.brands.index')}}?status=2" class="btn seeMore">See More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-3 parentDataAll2">
        <div class="card-group">
            <div class="card col-lg-6 col-md-12 col-sm-12">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Influencers</h4>
                    </div>
                    <div class="inputs-influencer-canvas mt-3">
                        <form id="InfluencerFilterForm">
                            <div class="inputs mb-2">
                                <label>Country</label>
                                <select class="form-control select2 " name="countryFilterInfluencer"  id="countryFilterInfluencer">
                                    <option disabled selected> Select</option>
                                    @foreach($countries_active as $country)
                                        <option value={{$country->id}}> {{$country->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="inputs mb-2">
                                <label>Date</label>
                                <div id="reportrangeInfluencer" class="form-control">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                    <input type="hidden" value="startDateSearch" id="startDateSearchInfluencer" name="startDateSearchInfluencer">
                                    <input type="hidden" value="endDateSearch" id="endDateSearchInfluencer" name="endDateSearchInfluencer">
                                </div>
                            </div>
                            <div class="inputs mb-2">
                                <button class="btn" type="submit" id="InfluencerFilterSearchButton"><i class="fa fa-search-plus"></i> Search</button>
                                <button class="btn" type="button" id="InfluencerFilterResetButton"><i class="fa fa-filter"></i> Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body b-p-apex">

                    <div class="mt-4" id="influencer-container" data-value="{{$influencersChart}}" style="min-height:260px !important;">

                        <ul class="nav nav-tabs thirdNavTabs"  style="justify-content: space-around !important;" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link selectInfluencerTab active" id="influencer_active_tab"  data-status="1" data-type-influencer="active" data-toggle="tab" href="#influencer_active_content" role="tab" aria-controls="home" aria-selected="true">Active</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectInfluencerTab" id="influencer_inactive_tab" data-status="0" data-type-influencer="inactive" data-toggle="tab" href="#influencer_inactive_content" role="tab" aria-controls="profile" aria-selected="false">Inactive</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectInfluencerTab" id="influencer_pending_tab" data-status="2" data-type-influencer="pending" data-toggle="tab" href="#influencer_pending_content" role="tab" aria-controls="contact" aria-selected="false">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link selectInfluencerTab" id="influencer_reject_tab" data-status="3" data-type-influencer="reject" data-toggle="tab" href="#influencer_reject_content" role="tab" aria-controls="contact" aria-selected="false">Rejected</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="influencer_active_content" role="tabpanel" aria-labelledby="home-tab">
                                Influencer Active
                            </div>
                            <div class="tab-pane fade" id="influencer_inactive_content" role="tabpanel" aria-labelledby="profile-tab">
                                Influencer In-Active
                            </div>
                            <div class="tab-pane fade" id="influencer_pending_content" role="tabpanel" aria-labelledby="contact-tab">
                                Influencer Pending
                            </div>
                            <div class="tab-pane fade" id="influencer_reject_content" role="tabpanel" aria-labelledby="contact-tab">
                                Influencer Rejected
                            </div>
                        </div>

                        <canvas id="influencer-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="gutters col-lg-6 col-md-12 col-sm-12">
                <div>
                    <div class="table-container">
                        <div class="t-header">New Influencers Users</div>
                        <table id="exampleTblInfluencers" class="table custom-table resizable">
                            <thead>
                            <tr>
                                <th>name</th>
                                {{--                                <th>email</th>--}}
                                {{--                                <th>type</th>--}}
                                {{--                                <th>phone</th>--}}
                                {{--                                <th>Completed</th>--}}
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="col-md-4 col-sm-12">
                            <a href="{{route('dashboard.influences.index')}}?status=2" class="btn seeMore">See More</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="gutters col-lg-12 col-md-12 col-sm-12">
                <div>
                    <div class="table-container">
                        <div class="t-header">Complains</div>
                        <table id="exampleTblComplain" class="table custom-table resizable">
                            <thead>
                            <tr>
                                <th>Campaign name</th>
                                <th>Influencer Name</th>
                                <th>Complain</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{--    <div class="row gutters">--}}
    {{--        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">--}}
    {{--            <div class="table-container">--}}
    {{--                <div class="t-header">New Brands Users</div>--}}
    {{--                <table id="exampleTbl" class="table custom-table resizable">--}}
    {{--                    <thead>--}}
    {{--                    <tr>--}}
    {{--                        <th>name</th>--}}
    {{--                        <th>email</th>--}}
    {{--                        <th>type</th>--}}
    {{--                        <th>phone</th>--}}
    {{--                        <th>Completed</th>--}}
    {{--                        <th>Created at</th>--}}
    {{--                        <th>Actions</th>--}}
    {{--                    </tr>--}}
    {{--                    </thead>--}}
    {{--                    <tbody>--}}
    {{--                    </tbody>--}}
    {{--                </table>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <div class="row gutters">--}}
    {{--        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">--}}
    {{--            <div class="table-container">--}}
    {{--                <div class="t-header">New Influencers Users</div>--}}
    {{--                <table id="exampleTblInfluencers" class="table custom-table">--}}
    {{--                    <thead>--}}
    {{--                    <tr>--}}
    {{--                        <th>name</th>--}}
    {{--                        <th>email</th>--}}
    {{--                        <th>type</th>--}}
    {{--                        <th>phone</th>--}}
    {{--                        <th>Completed</th>--}}
    {{--                        <th>Created at</th>--}}
    {{--                        <th>Actions</th>--}}
    {{--                    </tr>--}}
    {{--                    </thead>--}}
    {{--                    <tbody>--}}
    {{--                    </tbody>--}}
    {{--                </table>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    @include('admin.dashboard.brands.models.brand_details')
    @include('admin.dashboard.campaign.models.reply_modal')
    @include('admin.dashboard.layouts.includes.general.models.expiration_date_model')
@endsection
@push('js')

    @include('admin.dashboard.layouts.includes.general.scripts.index')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    {{--    <script src="{{asset('js/charts/influencer_chart.js')}}"></script>--}}
    {{--    <script src="{{asset('js/charts/brand_chart.js')}}"></script>--}}
    {{--    <script src="{{asset('js/charts/campaign_chart.js')}}"></script>--}}
    {{--    <script type="module" src="{{asset('js/charts/campaign_chart.js')}}"></script>--}}
    <script src="{{asset('js/date_range.js')}}"></script>
    <script>

        $('#sub_brand_form').on('submit', function(e){
            e.preventDefault();
            console.log(10235);
        });

        $(".fourthAllCounts").click(function() {
            $('html, body').animate({
                scrollTop: $("#parentCampaignDataAll").offset().top
            }, 1000);
        })

        $(".thirdAllCounts").click(function() {
            $('html, body').animate({
                scrollTop: $(".parentDataAll").offset().top
            }, 1000);
        })

        $(".secondAllCounts").click(function() {
            $('html, body').animate({
                scrollTop: $(".parentDataAll2").offset().top
            }, 1000);
        })



        let salesTbl = null
        let influencersTable = null
        // import initChart from "../../../../public/js/charts/campaign_chart";
        $(document).ready(function (){
            $('#operaionSectionFilterCountry').on('change',function (){
                var country = $(this).val();
                var type = 'operations';
                $.ajax({
                    url:`/dashboard/filterSectionsStats`,
                    type:'get',
                    data:{
                        'country_val':country,
                        'role':type,
                    },
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:({data})=>{
                        $('.firstStats').empty()
                        $('.secondStats').empty()
                        $('.thirdStats').empty()
                        $('.fourthStats').empty()

                        let totals = '';
                        if(data.campaign.totalCamp){
                            let allCamps = data.campaign.totalCamp
                            for(let c in allCamps) {
                                if (allCamps.hasOwnProperty(c)) {
                                    totals+=`<li style="border: none;border-bottom: 1px solid #596280;" class="form-control">${c} : ${allCamps[c]}</li>`
                                }
                            }
                        }else{
                            totals=`<li style="border: none;border-bottom: 1px solid #596280;" class="form-control">No Campaigns</li>`
                        }

                        $('.fourthStats').append(`
                          <li>
                            <div class="btn-group dropright">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="display: flex;align-items: center;justify-content: center;background: transparent;padding: 0">
                                   <span class="stat-icon bg-info" style="padding: 5px;margin-right: 11px; width: auto; height: auto;display: flex;align-items: center;justify-content: center;">
                                       <i class="icon-eye1" style="margin: 0 !important;padding: 5px;"></i>
                                   </span>
                                    Total:${data.campaign.totalCamp ? data.campaign.totals : 0}
                                            </button>
                                            <div class="dropdown-menu" style="position: absolute; transform: translate3d(113px, 0px, 0px); top: 0px;left: 0px;will-change: transform;background: #1a233a;">
                                                <ul>
                                                    ${totals}
                                                </ul>
                                        </div>
                                    </div>
                          </li>
                          <li>
									<span class="stat-icon bg-success">
													<i class="icon-import_contacts"></i>
												</span>
                                    Visit : ${data.campaign.visitCamp}
                        </li>
                        <li>
                                        <span class="stat-icon bg-info">
                                            <i class="icon-local_airport"></i>
                                        </span>
                            Delivery :${data.campaign.deliveryCamp}
                        </li>
                        <li>
                                        <span class="stat-icon bg-warning">
                                            <i class="icon-swap_horiz"></i>
                                        </span>
                            Mixed : ${data.campaign.mixCamp}
                        </li>
                        `)


                        $('.firstStats').append(`
                            <li>
                                <span class="stat-icon bg-info">
                                    <i class="icon-eye1"></i>
                            </span>
                                Total : ${data.operations.totalOperations}
                            </li>
                            <li>
                                <span class="stat-icon bg-success">
                                    <i class="icon-toggle-right"></i>
                            </span>
                                Active : ${data.operations.activeOperations}
                            </li>
                            <li>
                                <span class="stat-icon bg-danger">
                                    <i class="icon-toggle-left"></i>
                            </span>
                                Inactive : ${data.operations.inactiveOperations}
                            </li>
                        `);
                        $('.secondStats').append(`
                            <li>
                                    <span class="stat-icon bg-info">
                                        <i class="icon-eye1"></i>
                                    </span>
                                    Total : ${data.influencer.totalInfluencer}
                            </li>
                            <li>
                                            <span class="stat-icon bg-success">
                                                <i class="icon-toggle-right"></i>
                                            </span>
                                Active: ${data.influencer.activeInfluencer}
                            </li>
                            <li>
                                                <span class="stat-icon bg-danger">
                                                <i class="icon-toggle-left"></i>
                                            </span>
                                 Inactive : ${data.influencer.inactiveInfluencer}
                            </li>
                            <li>
                                            <span class="stat-icon bg-info">
                                                <i class="icon-loader"></i>
                                            </span>
                                Pending : ${data.influencer.pendingInfluencer}
                            </li>
                            <li>
                                            <span class="stat-icon bg-warning">
                                                <i class="icon-x-circle"></i>
                                            </span>
                                Rejected : ${data.influencer.rejectedInfluencer}
                            </li>
                            `)
                        $('.thirdStats').append(`
                                                        <li>
												<span class="stat-icon bg-info">
													<i class="icon-eye1"></i>
												</span>
                                    Total : ${data.brand.totalBrand}
                        </li>
                        <li>
                                        <span class="stat-icon bg-success">
                                            <i class="icon-toggle-right"></i>
                                        </span>
                            Active: ${data.brand.activeBrand}
                        </li>
                        <li>
                                        <span class="stat-icon bg-danger">
                                            <i class="icon-toggle-left"></i>
                                        </span>
                            Inactive : ${data.brand.inactiveBrand}
                        </li>
                        <li>
                                        <span class="stat-icon bg-info">
                                            <i class="icon-loader"></i>
                                        </span>
                            Pending : ${data.brand.pendingBrand}
                        </li>
                        <li>
                                        <span class="stat-icon bg-warning">
                                            <i class="icon-x-circle"></i>
                                        </span>
                            Rejected : ${data.brand.rejectedBrand}
                        </li>
                    `)


                    },
                    error:(data)=>{
                        // console.log(data);
                    }
                })
            })

            $('#activeCampsFilterDateBtn').on('click',function (){
                var start_date = $('#startDateSearchActive').val();
                var end_date = $('#endDateSearchActive').val();
                $('.ulActiveData').empty()
                filterCampsData(start_date,end_date,0)
            })

            $('#pendingCampsFilterDateBtn').on('click',function (){
                var start_date = $('#startDateSearchPending').val();
                var end_date = $('#endDateSearchPending').val();
                $('.ulPendingData').empty()
                filterCampsData(start_date,end_date,1)
            })


            function filterCampsData(start_date,end_date,type){
                $.ajax({
                    url:`/dashboard/getactivecamps`,
                    type:'get',
                    data:{
                        'start_date':start_date,
                        'end_date':end_date,
                        'type':type,
                    },
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:(res)=>{
                        var type = ''
                        let data = res.data
                        if(data.length > 0){
                            data.forEach((camp) => {
                                if(camp.campaign_type == 2)
                                    type =  "mixed";
                                else if (camp.campaign_type == 1)
                                    type =  'delivery';
                                else
                                    type =  'visit';

                                if(res.typeCamp == 0){
                                    $('.ulActiveData').append(`
                                   <li class="todo-list">
                                    <div class="todo-info">
                                        <span class="dot blue"></span>
                                        <p>${camp.name}</p>
                                        <p class="mb-0 tx-13 text-muted">
                                            ${camp.brand.name ?? 'No Brand'}
                                        <span class="text-success ms-2">${type}</span>
                                        </p>
                                        <p class="dt">${moment(camp.updated_at).format('DD-MMM-YYYY')}</p>
                                    </div>
                                    </li>`
                                    )
                                }else if(res.typeCamp == 1){
                                    $('.ulPendingData').append(`
                                   <li class="todo-list">
                                    <div class="todo-info">
                                        <span class="dot blue"></span>
                                        <p>${camp.name}</p>
                                        <p class="mb-0 tx-13 text-muted">
                                            ${camp.brand.name ?? 'No Brand'}
                                        <span class="text-success ms-2">${type}</span>
                                        </p>
                                        <p class="dt">${moment(camp.updated_at).format('DD-MMM-YYYY')}</p>
                                    </div>
                                    </li>`
                                    )
                                }

                            })
                        }else{
                            if(res.typeCamp == 0){
                                $('.ulActiveData').append(`
                                   <li class="todo-list">
                                        No Campaigns
                                   </li>`);
                            }else if(res.typeCamp == 1){
                                $('.ulPendingData').append(`
                                   <li class="todo-list">
                                        No Campaigns
                                   </li>`);
                            }
                        }


                    },
                    error:(data)=>{
                        // console.log(data);
                    }
                })
            }

            //$('#active_visit_tab').on('click',function (){
            //    renderChartCamp()
            //    handleCampStatus(0,'visit',0);
            //})
            //$('#completed_visit_tab').on('click',function (){
            //    renderChartCamp()
            //    handleCampStatus(2,'visit',0);
            //})
            //$('#onhold_visit_tab').on('click',function (){
            //    renderChartCamp()
            //    handleCampStatus(5,'visit',0);
            //})

            //delivery
            //$('#onhold_delivery_tab').on('click',function (){
            //    renderChartCamp()
            //    handleCampStatus(5,'delivery',1);
            //})
            //$('#completed_delivery_tab').on('click',function (){
            //    renderChartCamp()
            //    handleCampStatus(2,'delivery',1);
            //})
            //$('#active_delivery_tab').on('click',function (){
            //    renderChartCamp()
            //    handleCampStatus(0,'delivery',1);
            //})
            //mix
            //$('#onhold_mix_tab').on('click',function (){
            //    renderChartCamp()
            //    handleCampStatus(5,'mix',2);
            //})
            //$('#completed_mix_tab').on('click',function (){
            //    renderChartCamp()
            //    handleCampStatus(2,'mix',2);
            //})
            //$('#active_mix_tab').on('click',function (){
            //    renderChartCamp()
            //    handleCampStatus(0,'mix',2);
            //})


            //////////////////////////////// Brand Tabs ///////////////////////////////
            //$('#brand_active_tab').on('click',function (){
            //    renderChartBrands()
            //    handleBrandsStatus(1,'active');
            //})
            //$('#brand_inactive_tab').on('click',function (){
            //    renderChartBrands()
            //    handleBrandsStatus(0,'inactive');
            //})
            //$('#brand_pending_tab').on('click',function (){
            //    renderChartBrands()
            //    handleBrandsStatus(2,'pending');
            //})
            //$('#brand_reject_tab').on('click',function (){
            //    renderChartBrands()
            //    handleBrandsStatus(3,'reject');
            //})

            $('#BrandFilterForm').on('submit', function(e){
                e.preventDefault();
                var selectedTab = $(".selectBrandTab.active").attr('id');
                var statusBrand = $('#'+selectedTab).data('status');
                var typeBrand = $('#'+selectedTab).data('type-brand');
                console.log(statusBrand, typeBrand);
                renderChartBrands();
                handleBrandsStatus(statusBrand, typeBrand);
            });

            $('.selectBrandTab').on('click', function(){
                var selectedTab = $(this).attr('id');
                var statusBrand = $('#'+selectedTab).data('status');
                var typeBrand = $('#'+selectedTab).data('type-brand');
                renderChartBrands();
                handleBrandsStatus(statusBrand, typeBrand);
            });

            $('#BrandFilterResetButton').on('click', function(){
                //Reset Form
                $('#BrandFilterForm').trigger('reset');
                $('#BrandFilterForm').find('input[type=hidden]').each(function(i,v){
                    inputId = $('#'+$(this).attr('id'));
                    inputId.val(" ");
                    var spanDate = inputId.closest("#reportrangeBrand").find('span');
                    spanDate.html('');
                });
                //Reset Chart And Fill It With New Data
                var selectedTab = $(".selectBrandTab.active").attr('id');
                var statusBrand = $('#'+selectedTab).data('status');
                var typeBrand = $('#'+selectedTab).data('type-brand');
                renderChartBrands();
                handleBrandsStatus(statusBrand, typeBrand,);
            });

            //////////////////////////////// Influencer Tabs ///////////////////////////////

            //$('#influencer_active_tab').on('click',function (){
            //    renderChartInfluencers()
            //    handleInfluencersStatus(1,'active');
            //})
            //$('#influencer_inactive_tab').on('click',function (){
            //    renderChartInfluencers()
            //    handleInfluencersStatus(0,'inactive');
            //})
            //$('#influencer_pending_tab').on('click',function (){
            //    renderChartInfluencers()
            //    handleInfluencersStatus(2,'pending');
            //})
            //$('#influencer_reject_tab').on('click',function (){
            //    renderChartInfluencers()
            //    handleInfluencersStatus(3,'reject');
            //})

            function renderChartInfluencers(){
                $('#influencer-chart').remove();
                $('#influencer-container').append('<canvas id="influencer-chart"></canvas>')
                let canvas = document.querySelector('#influencer-chart');
                ctx = canvas.getContext('2d');
                ctx.canvas.width = 728
                ctx.canvas.height = 364
            }

            function initChartInfluencers (influencerValue,influencerStatus){
                if(typeof influencerValue != 'object')
                    influencerValue = JSON.parse(influencerValue)
                let labelsBrand = [] , data=[]
                for(let s in influencerValue) {
                    labelsBrand.push(s);
                    if(influencerStatus == 'inactive')
                        data.push(influencerValue[s]['inactive'])
                    else if(influencerStatus == 'active')
                        data.push(influencerValue[s]['active'])
                    else if(influencerStatus == 'pending')
                        data.push(influencerValue[s]['pending'])
                    else if(influencerStatus == 'reject')
                        data.push(influencerValue[s]['reject'])
                }
                console.log(data)


                const brandData = {
                    labels: labelsBrand,
                    datasets: [
                        {
                            label: influencerStatus,
                            backgroundColor: '#5A451D',
                            borderColor: '#fff',
                            data: data,
                        },
                    ]
                };
                const influencerConfig = {
                    type: 'bar',
                    data: brandData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Influencers'
                            }
                        },
                        scales: {
                            y: {
                                ticks: {
                                    color: '#fff'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#fff'
                                }
                            }
                        }
                    },
                };
                const influencerChart = new Chart(
                    document.getElementById('influencer-chart'),
                    influencerConfig
                );
            }

            initChartInfluencers($('#influencer-container').data('value'),'active')

            $('#InfluencerFilterForm').on('submit', function(e){
                e.preventDefault();
                var selectedTab = $(".selectInfluencerTab.active").attr('id');
                var statusInfluencer = $('#'+selectedTab).data('status');
                var typeInfluencer = $('#'+selectedTab).data('type-influencer');
                console.log(statusInfluencer, typeInfluencer);
                renderChartInfluencers();
                handleInfluencersStatus(statusInfluencer, typeInfluencer);
            });

            $('.selectInfluencerTab').on('click', function(){
                var selectedTab = $(this).attr('id');
                var statusInfluencer = $('#'+selectedTab).data('status');
                var typeInfluencer = $('#'+selectedTab).data('type-influencer');
                renderChartInfluencers();
                handleInfluencersStatus(statusInfluencer, typeInfluencer);
            });

            $('#InfluencerFilterResetButton').on('click', function(){
                //Reset Form
                $('#InfluencerFilterForm').trigger('reset');
                $('#InfluencerFilterForm').find('input[type=hidden]').each(function(i,v){
                    inputId = $('#'+$(this).attr('id'));
                    inputId.val(" ");
                    var spanDate = inputId.closest("#reportrangeInfluencer").find('span');
                    spanDate.html('');
                });
                //Reset Chart And Fill It With New Data
                var selectedTab = $(".selectInfluencerTab.active").attr('id');
                var statusInfluencer = $('#'+selectedTab).data('status');
                var typeInfluencer = $('#'+selectedTab).data('type-influencer');
                renderChartInfluencers();
                handleInfluencersStatus(statusInfluencer, typeInfluencer,);
            });

            async function handleInfluencersStatus(statusInfluencer,typeInfluencer){
                disabledAndUndisabledTabs(1,'influencer')
                var startDateSearch = $('#startDateSearchInfluencer').val()
                var endDateSearch = $('#endDateSearchInfluencer').val()
                var countryFilter = $('#countryFilterInfluencer').val()
                if(countryFilter != null){
                    countryFilter = countryFilter.split(' ')
                }else{
                    countryFilter = null;
                }
                $.ajax({
                    url:`/dashboard/`,
                    type:'get',
                    data:{
                        'statusInfluencer':statusInfluencer,
                        'typeInfluencer':typeInfluencer,
                        'countries_id':countryFilter,
                        'start_date':startDateSearch,
                        'end_date':endDateSearch,
                        // 'campaign_type_val':campaign_type_val,
                    },
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:({influencer})=>{
                        if(statusInfluencer == 0)
                            initChartInfluencers(JSON.stringify(influencer),'inactive');
                        else if(statusInfluencer == 1)
                            initChartInfluencers(JSON.stringify(influencer),'active');
                        else if(statusInfluencer == 2)
                            initChartInfluencers(JSON.stringify(influencer),'pending');
                        else if(statusInfluencer == 3)
                            initChartInfluencers(JSON.stringify(influencer),'reject');

                        disabledAndUndisabledTabs(0,'influencer')

                    },
                    error:(data)=>{
                        // console.log(data);
                        disabledAndUndisabledTabs(0,'influencer')
                    }
                })

            }

            //////////////////////////////// Influencer Tabs ///////////////////////////////


            function renderChartCamp(){
                $('#campaign-chart').remove();
                $('#campaign-container').append('<canvas id="campaign-chart"></canvas>')
                let canvas = document.querySelector('#campaign-chart');
                ctx = canvas.getContext('2d');
                ctx.canvas.width = 1143
                ctx.canvas.height = 571
            }

            function renderChartBrands(){
                $('#brand-chart').remove();
                $('#brand-container').append('<canvas id="brand-chart"></canvas>')
                let canvas = document.querySelector('#brand-chart');
                ctx = canvas.getContext('2d');
                ctx.canvas.width = 728
                ctx.canvas.height = 364
            }


            initChartBrands($('#brand-container').data('value'),'active')
            function initChartBrands (brandValue,brandStatus){
                if(typeof brandValue != 'object')
                    brandValue = JSON.parse(brandValue)
                let labelsBrand = [] , data=[]
                for(let s in brandValue) {
                    labelsBrand.push(s);
                    if(brandStatus == 'inactive')
                        data.push(brandValue[s]['inactive'])
                    else if(brandStatus == 'active')
                        data.push(brandValue[s]['active'])
                    else if(brandStatus == 'pending')
                        data.push(brandValue[s]['pending'])
                    else if(brandStatus == 'reject')
                        data.push(brandValue[s]['reject'])
                }

                const brandData = {
                    labels: labelsBrand,
                    datasets: [
                        {
                            label: brandStatus,
                            backgroundColor: '#5A451D',
                            borderColor: '#fff',
                            data: data,
                        },
                    ]
                };
                const brandConfig = {
                    type: 'bar',
                    data: brandData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Brands'
                            }
                        },
                        scales: {
                            y: {
                                ticks: {
                                    color: '#fff'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#fff'
                                }
                            }
                        }
                    }
                };
                const brandChart = new Chart(
                    document.getElementById('brand-chart'),
                    brandConfig
                );
            }

            //$('#countryFilter').on('change', function(){
            //    console.log(105);
            //    renderChartCamp()
            //    handleCampStatus(0,'visit',0);
            //});

            //$('#countryFilterBrand').on('change', function(){
            //    renderChartBrands()
            //    handleBrandsStatus(1,'active');
            //});

            $('#CampaignFilterResetButton').on('click', function(){
                //Reset Form
                $('#CampaignFilterForm').trigger('reset');
                $('#CampaignFilterForm').find('input[type=hidden]').each(function(i,v){
                    inputId = $('#'+$(this).attr('id'));
                    inputId.val(" ");
                    var spanDate = inputId.closest("#reportrange").find('span');
                    spanDate.html('');
                });
                //Reset Chart And Fill It With New Data
                var selectedTab = $(".selectCampaingTab.active").attr('id');
                var statusCamp = $('#'+selectedTab).data('status');
                var typeCamp = $('#'+selectedTab).data('type-camp');
                var CampTypeVal = $('#'+selectedTab).data('camp-type-val');
                console.log(516);
                renderChartCamp();
                handleCampStatus(statusCamp, typeCamp, CampTypeVal);
            });

            $('#CampaignFilterForm').on('submit', function(e){
                e.preventDefault();
                var selectedTab = $(".selectCampaingTab.active").attr('id');
                var statusCamp = $('#'+selectedTab).data('status');
                var typeCamp = $('#'+selectedTab).data('type-camp');
                var CampTypeVal = $('#'+selectedTab).data('camp-type-val');
                renderChartCamp();
                handleCampStatus(statusCamp, typeCamp, CampTypeVal);
            });

            $('.selectCampaingTab').on('click', function(){
                selectedTab = $(this).attr('id');
                var statusCamp = $('#'+selectedTab).data('status');
                var typeCamp = $('#'+selectedTab).data('type-camp');
                var CampTypeVal = $('#'+selectedTab).data('camp-type-val');
                renderChartCamp();
                handleCampStatus(statusCamp, typeCamp, CampTypeVal);
            });

            async function handleCampStatus(status,typeCamp,campaign_type_val){
                renderChartCamp();

                disabledAndUndisabledTabs(1,'campaign')
                var startDateSearch = $('#startDateSearch').val()
                var endDateSearch = $('#endDateSearch').val()
                var countryFilter = $('#countryFilter').val()
                console.log(countryFilter);
                if(countryFilter != null){
                    countryFilter = countryFilter.split(' ')
                }else{
                    countryFilter = null;
                }
                $.ajax({
                    url:`/dashboard/`,
                    type:'get',
                    data:{
                        'status_val':status,
                        'typeCamp':typeCamp,
                        'country_val':countryFilter,
                        'start_date':startDateSearch,
                        'end_date':endDateSearch,
                        'campaign_type_val':campaign_type_val,
                    },
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:({camp})=>{
                        let data = camp
                        if(status == 0 && typeCamp == 'visit'){
                            console.log('camp', JSON.stringify(data));
                            initChart(JSON.stringify(data),'visit','active');
                            drawDivChartData(data)
                        }
                        else if(status == 5 && typeCamp == 'visit'){
                            initChart(JSON.stringify(data),'visit','onhold');
                            drawDivChartData(data)
                        }
                        else if(status == 2 && typeCamp == 'visit'){
                            initChart(JSON.stringify(data),'visit','completed');
                            drawDivChartData(data)
                        }
                        else if(status == 0 && typeCamp == 'delivery'){
                            initChart(JSON.stringify(data),'delivery','active');
                            drawDivChartData(data)
                        }
                        else if(status == 5 && typeCamp == 'delivery'){
                            initChart(JSON.stringify(data),'delivery','onhold');
                            drawDivChartData(data)
                        }
                        else if(status == 2 && typeCamp == 'delivery'){
                            initChart(JSON.stringify(data),'delivery','completed');
                            drawDivChartData(data)
                        }
                        else if(status == 0 && typeCamp == 'mix'){
                            initChart(JSON.stringify(data),'mix','active');
                            drawDivChartData(data)
                        }
                        else if(status == 5 && typeCamp == 'mix'){
                            initChart(JSON.stringify(data),'mix','onhold');
                            drawDivChartData(data)
                        }
                        else if(status == 2 && typeCamp == 'mix'){
                            initChart(JSON.stringify(data),'mix','completed');
                            drawDivChartData(data)
                        }
                        disabledAndUndisabledTabs(0,'campaign')
                    },
                    error:(data)=>{
                        disabledAndUndisabledTabs(0,'campaign')
                    }
                })
            }

            function disabledAndUndisabledTabs(val,type){
                if(type == 'campaign'){
                    if(val == 1){
                        $('.firstNavTabs li').each(function () {
                            $(this).addClass("disabledbutton");
                        });
                    }else{
                        $('.firstNavTabs li').each(function () {
                            $(this).removeClass("disabledbutton");
                        });
                    }
                }else if(type == 'influencer'){
                    if(val == 1){
                        $('.thirdNavTabs li').each(function () {
                            $(this).addClass("disabledbutton");
                        });
                    }else{
                        $('.thirdNavTabs li').each(function () {
                            $(this).removeClass("disabledbutton");
                        });
                    }
                }else if(type == 'brand'){
                    if(val == 1){
                        $('.secondNavTabs li').each(function () {
                            $(this).addClass("disabledbutton");
                        });
                    }else{
                        $('.secondNavTabs li').each(function () {
                            $(this).removeClass("disabledbutton");
                        });
                    }
                }

            }

            function drawDivChartData(data){
                $('.campChartDataParent').empty()
                if(Object.keys(data).length > 0){
                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            $('.campChartDataParent').append(`
                                <div class="campChartData mb-2">
                                    <p>${key}</p>
                                    <p>${JSON.stringify(data[key]).replace(/{/g," ").replace(/"/g," ").substring(0,JSON.stringify(data[key]).length-1) }</p>
                                </div>
                            `);
                        }
                    }
                }else{
                    $('.campChartDataParent').append(`
                        <div class="campChartData mb-2">
                            <p>There Are No Campaigns</p>
                        </div>
                    `);
                }
            }
            ///////////////////////////////////////////////

            initChart($('#campaign-container').data('value'),'visit','active');
            function initChart (campaignValue,campaignType,campaignStatus){
                if(typeof campaignValue != 'object')
                    campaignValue = JSON.parse(campaignValue)
                let labelsCampaign = [] , data=[]
                for(let s in campaignValue) {
                    labelsCampaign.push(s);
                    if(campaignType == 'visit' && campaignStatus == 'active'){
                        data.push(campaignValue[s]['Active_visit'])
                    }else if(campaignType == 'visit' && campaignStatus == 'onhold'){
                        data.push(campaignValue[s]['Onhold_visit'])
                    }else if(campaignType == 'visit' && campaignStatus == 'completed'){
                        data.push(campaignValue[s]['Finished_visit'])
                    }else if(campaignType == 'delivery' && campaignStatus == 'active'){
                        data.push(campaignValue[s]['Active_delivery'])
                    }else if(campaignType == 'delivery' && campaignStatus == 'onhold'){
                        data.push(campaignValue[s]['Onhold_delivery'])
                    }else if(campaignType == 'delivery' && campaignStatus == 'completed'){
                        data.push(campaignValue[s]['Finished_delivery'])
                    }else if(campaignType == 'mix' && campaignStatus == 'active'){
                        data.push(campaignValue[s]['Active_mix'])
                    }else if(campaignType == 'mix' && campaignStatus == 'onhold'){
                        data.push(campaignValue[s]['Onhold_mix'])
                    }else if(campaignType == 'mix' && campaignStatus == 'completed'){
                        data.push(campaignValue[s]['Finished_mix'])
                    }
                }

                const campaignData = {
                    labels: labelsCampaign,
                    datasets: [
                        {
                            label: campaignStatus + ' ' + campaignType,
                            backgroundColor: '#5A451D',
                            borderColor: '#fff',
                            data: data,
                        }
                    ]
                };
                const campaignConfig = {
                    type: 'bar',
                    data: campaignData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Campaigns'
                            }
                        },
                        scales: {
                            y: {
                                ticks: {
                                    color: '#fff'
                                },
                            },
                            x: {
                                ticks: {
                                    color: '#fff'
                                }
                            }
                        }
                    }
                };
                var campaignChart = new Chart(
                    document.getElementById('campaign-chart'),
                    campaignConfig
                );
            }

            async function handleBrandsStatus(status,typeBrand){
                disabledAndUndisabledTabs(1,'brand')
                var startDateSearch = $('#startDateSearchBrand').val()
                var endDateSearch = $('#endDateSearchBrand').val()
                var countryFilter = $('#countryFilterBrand').val()
                console.log(countryFilter);
                if(countryFilter != null){
                    countryFilter = countryFilter.split(' ')
                }else{
                    countryFilter = null;
                }
                $.ajax({
                    url:`/dashboard/`,
                    type:'get',
                    data:{
                        'status':status,
                        'typeBrand':typeBrand,
                        'country_val':countryFilter,
                        'start_date':startDateSearch,
                        'end_date':endDateSearch,
                        // 'campaign_type_val':campaign_type_val,
                    },
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success:({brand})=>{
                        if(status == 0)
                            initChartBrands(JSON.stringify(brand),'inactive');
                        else if(status == 1)
                            initChartBrands(JSON.stringify(brand),'active');
                        else if(status == 2)
                            initChartBrands(JSON.stringify(brand),'pending');
                        else if(status == 3)
                            initChartBrands(JSON.stringify(brand),'reject');

                        disabledAndUndisabledTabs(0,'brand')
                    },
                    error:(data)=>{
                        // console.log(data);
                        disabledAndUndisabledTabs(0,'brand')

                    }
                })

            }

            ActiveCampsTable = $('#exampleTblActiveCamp').DataTable({
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                fixedHeader : {
                    header : true,
                    footer : false,
                },
                dom: 'Blfrtip',
                "buttons": [],
                'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                ajax: {
                    url :"{{route('dashboard.campaigns.datatable')}}?status_val=0",
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.tableType = 1
                        d.start_date = "{{\request('start_date')}}";
                        d.end_date = "{{\request('end_date')}}";
                    }
                },
                "columns": [
                    {"data": "name"},
                    {"data": "brand"},
                    {
                        "data": "start_date",
                        render:function (data, type){
                            if( jQuery.type(data) == 'object'){
                                let html = `<div class="row">`
                                html+=`<div class="col-md-12"> Visit : ${ data['visit'] }</div>`
                                html+=`<div class="col-md-12"> Delivery : ${ data['delivery'] }</div>`
                                html += `</div>`
                                return html
                            }else{
                                return data
                            }
                        }
                    },
                    {"data": "type"},
                    {
                        "data": "camp_id",
                        render: function (data, type) {
                            let route_edit = '/dashboard/campaigns/' + data.id + '/edit'
                            let route_show = '/dashboard/campaigns/' + data.id
                            $t = `<td>
                                    <div class="actions">
                                        @can('read campaigns')
                                            <a style="background:transparent !important;width:2px !important;" href="${route_show}" class="btn btn-success"  data-toggle="tooltip" data-placement="top" title="Show Campaign">
                                                <i class="icon-eye text-warning" style="font-size:16px;"></i>
                                            </a>
                                        @endcan

                                        @can('update campaigns')
                                            <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-primary"  data-placement="top" title="Edit Campaign" >
                                                <i class="icon-edit-3 text-success" style="font-size:16px;"></i>
                                            </a>
                                        @endcan
                                        @can('delete campaigns')
                                            <button style="background:transparent !important;width:2px !important;" class="campaigns btn btn-danger delRow" data-id="${data.id}" data-table="ActiveCampsTable" id="del-${data.id}" data-toggle="tooltip" data-placement="top" title="Delete Campaign" >
                                                    <i class="icon-trash-2 text-danger" style="font-size:16px;"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>`;
                                if(data.status.value != 0){
                                    $t +=
                                    `@can('update campaigns')
                                        <button style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Active Campaign" class="btn btn-success mt-2 mb-2 acceptRow active_campaign" id="accept-${data.id}" data-id="${data.id}" >
                                                    <i class="icon-check-circle" style="font-size: 16px;"></i>
                                        </button>
                                    @endcan`
                                }
                                return $t;
                        }
                    }
                ],
                createdRow: function (row,data) {

                },
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                }
            })

            PendingCampsTable = $('#exampleTblPendingCamp').DataTable({
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                fixedHeader : {
                    header : true,
                    footer : false,
                },
                dom: 'Blfrtip',
                "buttons": [],
                'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                ajax: {
                    url :"{{route('dashboard.campaigns.datatable')}}?status_val=1",
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.tableType = 1
                        d.start_date = "{{\request('start_date')}}";
                        d.end_date = "{{\request('end_date')}}";
                    }
                },
                "columns": [
                    {"data": "name"},
                    {"data": "brand"},
                    {
                        "data": "start_date",
                        render:function (data, type){
                            if( jQuery.type(data) == 'object'){
                                let html = `<div class="row">`
                                html+=`<div class="col-md-12"> Visit : ${ data['visit'] }</div>`
                                html+=`<div class="col-md-12"> Delivery : ${ data['delivery'] }</div>`
                                html += `</div>`
                                return html
                            }else{
                                return data
                            }
                        }
                    },
                    {"data": "type"},
                    {
                        "data": "camp_id",
                        render: function (data, type) {
                            let route_edit = '/dashboard/campaigns/' + data.id + '/edit'
                            let route_show = '/dashboard/campaigns/' + data.id
                            $t = `<td>
                                    <div class="actions">
                                        @can('read campaigns')
                                            <a style="background:transparent !important;width:2px !important;" href="${route_show}" class="btn btn-success"  data-toggle="tooltip" data-placement="top" title="Show Campaign">
                                                <i class="icon-eye text-warning" style="font-size:16px;"></i>
                                            </a>
                                        @endcan

                                        @can('update campaigns')
                                            <a style="background:transparent !important;width:2px !important;" href="${route_edit}" class="btn btn-primary"  data-placement="top" title="Edit Campaign" >
                                                <i class="icon-edit-3 text-success" style="font-size:16px;"></i>
                                            </a>
                                        @endcan
                                        @can('delete campaigns')
                                            <button style="background:transparent !important;width:2px !important;" class="campaigns btn btn-danger delRow" data-id="${data.id}" data-table="PendingCampsTable" id="del-${data.id}" data-toggle="tooltip" data-placement="top" title="Delete Campaign" >
                                                    <i class="icon-trash-2 text-danger" style="font-size:16px;"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>`;
                                if(data.status.value != 0){
                                    $t +=
                                    `@can('update campaigns')
                                        <button style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Active Campaign" class="btn btn-success mt-2 mb-2 acceptRow active_campaign" id="accept-${data.id}" data-id="${data.id}" >
                                                    <i class="icon-check-circle" style="font-size: 16px;"></i>
                                        </button>
                                    @endcan`

                                }

                                return $t;
                        }
                    }
                ],
                createdRow: function (row,data) {

                },
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                }
            })

            complainsTable = $('#exampleTblComplain').DataTable({
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                fixedHeader : {
                    header : true,
                    footer : false,
                },
                dom: 'Blfrtip',
                "buttons": [],
                'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                ajax: {
                    url :'/dashboard/complains',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.tableType = 1
                        d.start_date = "{{\request('start_date')}}";
                        d.end_date = "{{\request('end_date')}}";
                    }
                },
                columns: [
                        {
                            data: 'campaign_name',
                            render :function (data){
                                return `<a href="/dashboard/campaigns/${ data.id }">${data.name}</a>`
                            }
                        },
                        {data: 'influencer_name'},
                        {data: 'complain'},
                        {
                            data: 'status',
                            render :function (data){
                                let icon = '';
                                if(data.status == 0){
                                    icon =`<span class="badge badge-danger complain_status" data-status="0" data-campaign-id="${data.campaign_id}" data-complain-id="${data.id}">Unresolved</span>`
                                    //icon = '<i style="color: #22c03c;font-size: 22px;" class="icon-check-circle"></i>';
                                }else{
                                    icon =`<span class="badge badge-success complain_status" data-status="1" data-campaign-id="${data.campaign_id}" data-complain-id="${data.id}">Resolved</span>`
                                    //icon = '<i style="color: #ee335e;font-size: 22px;" class="icon-x-circle"></i>';
                                }
                             return icon;
                            }
                        },
                        {data: 'created_at'},
                        {
                            data: 'id',
                            render :function(data){
                                return `<a style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Show User" href="/dashboard/log/campaign/${data.campaign_id}" class="btn btn-dark mt-2 mb-2 pb-2 mr-2">
                                   <i class="icon-eye1 text-light" style="font-size: 16px;"></i>
                                </a>
                                <button style="color: #fff !important;" class="btn text-center openReplyModal reply_modal_button reply_modal" id="complain_reply_modal_${data.id}" data-type="reply" data-id='${data.id}' data-target="#reply_modal">Reply</button>
                                `
                            }
                        },
                    // {
                    //     data: 'image',
                    //     render :function (data){
                    //         return `<img src="${data}" class="img-thumbnail" style="width: 70px;height: 45px;" alt="user image">`;
                    //     }
                    // },
                    // {data: 'email'},
                    // {data: 'type',
                    //     render :function (data){
                    //         return `<span class="badge badge-info">${data.toUpperCase()}</span>`;
                    //     }},
                    // {data: 'phone'},
                    // {
                    //     data: 'user_data',
                    //     render :function (data){
                    //         let icon = '';
                    //         if(data.complete == 'Completed'){
                    //             icon = '<i style="color: #22c03c;font-size: 22px;" class="icon-check-circle"></i>';
                    //         }else{
                    //             icon = '<i style="color: #ee335e;font-size: 22px;" class="icon-x-circle"></i>';
                    //         }
                    //         return icon;
                    //     }
                    // },
                ],
                createdRow: function (row,data) {



                    //var stsId = data['user_data'].complete == 'Completed' ? 2 : 1;
                    //if (stsId == 1){
                    //    $(row).addClass('uncompleted');
                    //    $(row).attr('title','Un Completed');
                    //}else{
                    //    $(row).attr('title','Completed');
                    //}
                },
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                }
            })

            influencersTable = $('#exampleTblInfluencers').DataTable({
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                fixedHeader : {
                    header : true,
                    footer : false,
                },
                dom: 'Blfrtip',
                "buttons": [],
                'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                ajax: {
                    url :'/dashboard/recent-users',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.tableType = 1
                        d.start_date = "{{\request('start_date')}}";
                        d.end_date = "{{\request('end_date')}}";
                    }
                },
                columns: [
                    {
                        data: 'user_data',
                        render :function (data,type,full){
                            // let view_url = (full['type'] == "influencer") ? '/dashboard/social-scrape/'+data.id : '/dashboard/brands/'+data.id;
                            // return `
                            //     <img src="${full['image']}" class="img-thumbnail" style="width: 70px;height: 45px;" alt="user image">
                            //     <a href="${view_url}">${data.name}</a>`;
                            return `
                                <img src="${full['image']}" class="img-thumbnail" style="width: 70px;height: 45px;" alt="user image">
                            <button style="color: #fff !important;" class="btn text-center brand_modal" data-type="influencer" data-id = '${data.id}' data-toggle="modal" data-id="${data.id}"
                            data-target="#brand_modal">${data.name}</button>`;
                        }
                    },
                    // {
                    //     data: 'image',
                    //     render :function (data){
                    //         return `<img src="${data}" class="img-thumbnail" style="width: 70px;height: 45px;" alt="user image">`;
                    //     }
                    // },
                    // {data: 'email'},
                    // {data: 'type',
                    //     render :function (data){
                    //         return `<span class="badge badge-info">${data.toUpperCase()}</span>`;
                    //     }},
                    // {data: 'phone'},
                    // {
                    //     data: 'user_data',
                    //     render :function (data){
                    //         let icon = '';
                    //         if(data.complete == 'Completed'){
                    //             icon = '<i style="color: #22c03c;font-size: 22px;" class="icon-check-circle"></i>';
                    //         }else{
                    //             icon = '<i style="color: #ee335e;font-size: 22px;" class="icon-x-circle"></i>';
                    //         }
                    //         return icon;
                    //     }
                    // },
                    {"data": 'created_at'},
                    {
                        "data": "id",
                        render:function (data, type, full, meta){
                            // console.log(full['user_data'].complete == 'Completed')
                            let view_url = (full['type'] == "influencer") ? '/dashboard/social-scrape/'+full['user_data']['id'] : '/dashboard/brands/'+full['user_data']['id'];
                            let accept_btn = `<button style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Active User" ${(full['user_data']['complete'] == 'Completed')?'':'disabled'} class="btn btn-success mt-2 mb-2 acceptRow" id="accept-${data}" data-id="${data}" >
                                                <i class="icon-check-circle" style="font-size: 16px;"></i>
                                             </button>`;
                            let reject_btn = `<button style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Delete User" class="btn btn-danger mt-2 mb-2 rejectRow" id="reject-${data}" data-id="${data}" >
                                                <i class="icon-x-circle text-danger" style="font-size: 16px;"></i>
                                             </button>`;
                            let force_reject_btn = `<button style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Rejected User" class="btn btn-warning mt-2 mb-2 forceRejectRow" id="reject-${data}" data-id="${data}" >
                                                <i class="icon-power_settings_new text-warning" style="font-size: 16px;"></i>
                                             </button>`;

                            let inactive_btn = `<button style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Inactive User" class="btn btn-info mt-2 mb-2 inactiveRow" id="reject-${data}" data-id="${data}" >
                                                <i class="fa icon-toggle-left text-info" style="font-size: 16px;"></i>
                                             </button>`;
                            return `<td>
                                <a style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Show User" href="${view_url}" class="btn btn-dark mt-2 mb-2 pb-2">
                                   <i class="icon-eye1 text-light" style="font-size: 16px;"></i>
                                </a>
                                ${accept_btn}
                                ${reject_btn}
                                ${force_reject_btn}
                                ${inactive_btn}
                            </td>`;
                        }
                    },


                ],
                createdRow: function (row,data) {
                    var stsId = data['user_data'].complete == 'Completed' ? 2 : 1;
                    if (stsId == 1){
                        $(row).addClass('uncompleted');
                        $(row).attr('title','Un Completed');
                    }else{
                        $(row).attr('title','Completed');
                    }
                },
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                }
            })

            //////////////////////////////////////////////////////

            salesTbl = $('#exampleTbl').DataTable({
                lengthChange: true,
                processing: true,
                serverSide: true,
                responsive: true,
                fixedHeader : {
                    header : true,
                    footer : false,
                },
                dom: 'Blfrtip',
                "buttons": [],
                'columnDefs': [{ 'orderable': false, 'targets': 0 }],
                ajax: {
                    url :'/dashboard/recent-users',
                    headers:{'auth-id': $('meta[name="auth-id"]').attr('content')},
                    data: function (d) {
                        d.tableType = 0
                        d.start_date = "{{\request('start_date')}}";
                        d.end_date = "{{\request('end_date')}}";
                    }
                },
                columns: [
                    {
                        data: 'user_data',
                        render :function (data,type,full){
                            // let view_url = (full['type'] == "influencer") ? '/dashboard/social-scrape/'+data.id : '/dashboard/brands/'+data.id;
                            // return `
                            //     <img src="${full['image']}" class="img-thumbnail" style="width: 70px;height: 45px;" alt="user image">
                            //     <a href="${view_url}">${data.name}</a>`;
                            return `
                                <img src="${full['image']}" class="img-thumbnail" style="width: 70px;height: 45px;" alt="user image">
                            <button style="color: #fff !important;" class="btn text-center brand_modal" data-type="brand" data-id = '${data.id}' data-toggle="modal" data-id="${data.id}"
                            data-target="#brand_modal">${data.name}</button>`;


                        }
                    },
                    {"data": 'created_at'},
                    {
                        "data": "id",
                        render:function (data, type, full, meta){
                            let view_url = (full['type'] == "influencer") ? '/dashboard/social-scrape/'+full['user_data']['id'] : '/dashboard/brands/'+full['user_data']['id'];
                            let tableType =  (full['type'] == "influencer") ? "influencer" : "brands";
                            let accept_btn = `<button style="background:transparent" data-type="${tableType}" !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Active User" ${(full['user_data']['complete'] == 'Completed')?'':'disabled'} class="btn mt-2 mb-2 acceptRow" id="accept-${data}" data-id="${data}" >
                                                <i class="icon-check-circle" style="font-size: 16px;"></i>
                                             </button>`;
                            let reject_btn = `<button style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Delete User" class="btn btn-danger mt-2 mb-2 rejectRow" id="reject-${data}" data-id="${data}" >
                                                <i class="icon-x-circle text-danger" style="font-size: 16px;"></i>
                                             </button>`;
                            let force_reject_btn = `<button style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Reject User" class="btn btn-warning mt-2 mb-2 forceRejectRow" id="reject-${data}" data-id="${data}" >
                                                <i class="icon-power_settings_new text-warning" style="font-size: 16px;"></i>
                                             </button>`;

                            let inactive_btn = `<button style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Inactive User" class="btn btn-info mt-2 mb-2 inactiveRow" id="reject-${data}" data-id="${data}" >
                                                <i class="fa icon-toggle-left text-info" style="font-size: 16px;"></i>
                                             </button>`;
                            return `<td>
                                <a style="background:transparent !important;width:2px !important;" data-toggle="tooltip" data-placement="top" title="Show User" href="${view_url}" class="btn btn-dark mt-2 mb-2 pb-2">
                                   <i class="icon-eye1 text-light" style="font-size: 16px;"></i>
                                </a>
                                ${accept_btn}
                                ${reject_btn}
                                ${force_reject_btn}
                                ${inactive_btn}
                            </td>`;
                        }
                    },

                ],
                createdRow: function (row,data) {
                    var stsId = data['user_data'].complete == 'Completed' ? 2 : 1;
                    if (stsId == 1){
                        $(row).addClass('uncompleted');
                        $(row).attr('title','Un Completed');
                    }else{
                        $(row).attr('title','Completed');
                    }
                },
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                }
            })
            // new $.fn.dataTable.FixedHeader( salesTbl );

        })

        // Reply Modal
        $(document).on('click','.openReplyModal',function(){
            var complain_id = $(this).data('id');
            $('#reply_modal').toggle('true');
            $('[name=complain_id]').val(complain_id);
        });

        // Close Reply Modal
        $(document).on('click','.closeReplyModal',function(){
            $('#reply_modal').toggle('false');
            $('[name="reply"]').val(' ');
        });

        // Toggle Complain Status
        $(document).on('click', '.complain_status', function(){
            var complain_id = $(this).data('complain-id');
            var status = $(this).data('status') == 0 ? 1 : 0;
            console.log(status);
            $.ajax({
                url:`/dashboard/complain/update_status`,
                type:'get',
                data:{'_token': '{{ csrf_token() }}' , 'complain_id':complain_id, 'status':status},
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:(data)=>{
                    if(data.status){
                        status == 0 ? $(this).data('status', 0) : $(this).data('status', 1);
                        status == 0 ? $(this).text('Unresolved') : $(this).text('Resolved');
                        status == 0 ? $(this).removeClass('badge badge-success') : $(this).removeClass('badge badge-danger');
                        status == 0 ? $(this).addClass('badge badge-danger') : $(this).addClass('badge badge-success');
                        Swal.fire('success', 'Status Updated!', 'success');
                    }else{
                        swal.close();
                    }
                },
                error:(data)=>{
                    // console.log(data);
                }
            })
        })

        $('[data-toggle="tooltip"]').tooltip()

        function ajax(url) {
            return new Promise(function(resolve, reject) {
                var xhr = new XMLHttpRequest();
                xhr.onload = function() {
                resolve(this.responseText);
                };
                xhr.onerror = reject;
                xhr.open('GET', url);
                xhr.send();
            });
        }

        // accept row
        $(document).on('click','.acceptRow',function (){
            $('#expre_date_err').hide();
            $('#expre_date_err').text('');
            $('#expire_date_input').val('');
            let type = $(this).data('type');
            let id = $(this).data('id');
            $('#add_expiration_date').find('#brand_id').val(id);
            if(type == "brands"){
                $('#approve_brand_section').remove()
                $('#add_expiration_date').find('.parent_of_brand_countries').remove();
                $('.modal-body#modal_body').prepend(`
                    <div id="approve_brand_section">
                        <div class="parent_of_brand_image">
                            <label>Image</label>
                            <img src="" id="brand_image" style="widht:50px;height:50px">
                        </div>
                        <div class="parent_of_brand_name">
                            <label>Name</label>
                            <p id="brand_name"></p>
                        </div>
                        <div class="parent_of_brand_countries">
                            <label>Countries</label>
                            {!! Form::select("country_id[]", countries(), null,['class' =>'form-control select2 brand_countries_id'.($errors->has('country_id') ? 'parsley-error' : null),
                                'data-show-subtext'=>'true','data-live-search'=>'true', 'id' => 'brand_countries_id','multiple','style'=>'width:100%']) !!}
                            @error('country_id')
                                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                            @enderror
                            <small class="text-danger" id="expre_date_err"></small>
                        </div>
                    </div>
                `);

                //Init Select2
                $('.select2.brand_countries_id').select2({
                    dropdownParent: $('#add_expiration_date'),
                    placeholder: "Select",
                    allowClear: true
                });

                // Get Brand Countries
                ajax("{{ url('dashboard/brand-countries') }}/"+id)
                .then(function(result) {
                    console.log();
                    var res = JSON.parse(result);
                    $('.select2.brand_countries_id').val(res['countries']).trigger('change');
                    $('.parent_of_brand_image').find('img#brand_image').attr('src',res['brand']['image']);
                    $('.parent_of_brand_name').find('p#brand_name').html(res['brand']['name']);
                })
                .catch(function(data) {
                    // An error occurred
                    console.log('Error to get countries', data);
                });

            }else{
                $('#add_expiration_date').find('.select2.brand_countries_id').remove();
            }
            $('#add_expiration_date').modal('show');

        });

         $(document).on('click','#active_user',function (){
                var countries = [];
                var id = $('#add_expiration_date').find('#brand_id').val();

                countries = $('#add_expiration_date').find('select[name="country_id[]"]').val();
                swalAccept(id, countries);
                $('#add_expiration_date').modal('hide')
                $('#add_expiration_date').find('.parent_of_brand_countries').remove();
            });

        //$('.select2-selection__choice__remove').on('click', function(e){
        //    e.preventDefault();
        //    console.log($(this).val());
        //});


        // reject row
        $(document).on('click','.delRow',function (){
            let id = $(this).data('id');
            let table = $(this).data('table');
            console.log(id, table);
            swalDel(id,table);
        });

        function swalDel(id, tabel){
            Swal.fire({
                title: "Are you sure you want delete?",
                text: "You won't be able to restore this data",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Delete',
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((res)=>{
                if (res.isConfirmed){
                    let reqUrl = ``;
                    if(typeof id == "number")
                        reqUrl = `/dashboard/campaigns/${id}`;
                    else if(typeof id == "object")
                        reqUrl = `/dashboard/campaigns/bulk/delete`;
                    console.log(typeof id);
                    $.ajax({
                        url: reqUrl,
                        type:'delete',
                        data: {id},
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        success:()=>{
                            Swal.fire("Deleted!", "Deleted Successfully!", "success");
                            tabel.ajax.reload();
                        },
                        error:()=>{
                            Swal.fire("Error", "Something went wrong please reload page", "error");
                        }
                    })
                } else {
                    Swal.fire("Cancelled", "Canceled successfully!", "error");
                }
            })
        }

        // reject row
        $(document).on('click','.rejectRow',function (){
            let id = $(this).data('id');
            swal_reject_delete_inactive(id,'delete');
        });

        // reject row
        $(document).on('click','.rejectRow',function (){
            let id = $(this).data('id');
            swal_reject_delete_inactive(id,'delete');
        });

        // force reject row
        $(document).on('click','.forceRejectRow',function (){
            let id = $(this).data('id');
            swal_reject_delete_inactive(id,'reject');
        });

        // inactive row
        $(document).on('click','.inactiveRow',function (){
            let id = $(this).data('id');
            swal_reject_delete_inactive(id,'inactive');
        });

        function swalAccept(id, countries=[]){
            let accetp_swal = Swal.fire({
                title: "",
                text: "Are you sure to active this user?",
                type: "queston",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((result)=>{
                if (result.isConfirmed){
                    let expire_date = ($('#expire_date_input').val() != '' && $('#expire_date_input').val() != null) ? $('#expire_date_input').val() : -1;
                    let brand_country_active = (countries != '' && countries != null) ? countries : -1;
                    $.ajax({
                        url:`/dashboard/users-accept/${id}/${expire_date}`,
                        type:'post',
                        data:{'id':id, 'brand_countries':brand_country_active },
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        success:(data)=>{
                            if(data.status){
                                var stats = data.stats;
                                getStats(stats);
                                salesTbl.ajax.reload()
                                influencersTable.ajax.reload()
                                $('#add_expiration_date').modal('hide')
                                $('#add_expiration_date').find('.parent_of_brand_countries').remove();
                                $('#expire_date_input').val('')
                                Swal.fire("accepted!",data.message, "success");
                            }else{
                                swal.close();
                                let err = data.message.expirations_date[0];
                                $('#expre_date_err').show();
                                $('#expre_date_err').text(err)
                            }
                        },
                        error:(data)=>{
                            // console.log(data);
                        }
                    })
                } else {
                    $('#add_expiration_date').modal('hide')
                    $('#add_expiration_date').find('.parent_of_brand_countries').remove();
                    $('#expire_date_input').val('')
                    Swal.fire("Cancelled", "canceled successfully!", "error");
                }
            })
        }

        function getStats(stats){
            $('.activeBrand').text('Active : '+stats.activeBrand)
            $('.activeInfluencer').text('Active : '+stats.activeInfluencer)
            $('.activeOperations').text('Active : '+stats.activeOperations)
            $('.activeSales').text('Active : '+stats.activeSales)
            $('.deliveryCamp').text('Delivery : '+stats.deliveryCamp)
            $('.inactiveBrand').text('Inactive : '+stats.inactiveBrand)
            $('.inactiveInfluencer').text('Inactive : '+stats.inactiveInfluencer)
            $('.inactiveOperations').text('Inactive : '+stats.inactiveOperations)
            $('.inactiveSales').text('Inactive : '+stats.inactiveSales)
            $('.mixCamp').text('Mixed : '+stats.mixCamp)
            $('.pendingBrand').text('Pending : '+stats.pendingBrand)
            $('.pendingInfluencer').text('Pending : '+stats.pendingInfluencer)
            $('.rejectedBrand').text('Rejected : '+stats.rejectedBrand)
            $('.rejectedInfluencer').text('Rejected : '+stats.rejectedInfluencer)
            $('.totalBrand').text('Total Brands: '+stats.totalBrand)
            $('.totalCamp').text('Total Campaigns: '+stats.totalCamp)
            $('.totalInfluencer').text('Total Influencers: '+stats.totalInfluencer)
            $('.totalOperations').text('Total Admins: '+stats.totalOperations)
            $('.visitCamp').text('Visit : '+stats.visitCamp)
        }

        function swal_reject_delete_inactive(id,action_type){
            Swal.fire({
                title: "Are you sure to "+action_type+" this user?",
                text: "You will not be able to retrieve this record",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((result)=>{
                if (result.isConfirmed){
                    let reqUrl = ``;
                    if(action_type == 'delete'){
                        reqUrl = `/dashboard/users-reject/${id}`;
                    }else if(action_type == 'reject'){
                        reqUrl = `/dashboard/users-forcereject/${id}`;
                    }else if(action_type == 'inactive'){
                        reqUrl = `/dashboard/users-inactive/${id}`;
                    }

                    $.ajax({
                        url:reqUrl,
                        type:'put',
                        data:{id},
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        success:(data)=>{
                            if(data.status){
                                getStats(data.stats)
                            }
                            salesTbl.ajax.reload()
                            influencersTable.ajax.reload()
                            if(data.status){
                                Swal.fire("Done!", "Done Successfully!", "success");
                            }else{
                                Swal.fire("warning!", "can not Deleted!", "warning");
                            }
                        },
                        error:()=>{
                            Swal.fire("error", "something went wrong please reload page", "error");
                        }
                    })
                } else {
                    Swal.fire("Cancelled", "Canceled Successfully!", "error");
                }
            })
        }

        $(document).on('click','#go_search',function (){
            let from =  $('#startDateSearchAll').val();
            let to =  $('#endDateSearchAll').val();
            if(from && to )
                window.location = `?start_date=${from}&end_date=${to}`;
            else
                window.location.href = window.location.origin+window.location.pathname;
        });

        $('#FilterResetButton').on('click', function(){
            //Reset Form
            $('#CampaignFilterForm').trigger('reset');
            $('#reportrangeallfilter').find('input[type=hidden]').each(function(i,v){
                inputId = $('#'+$(this).attr('id'));
                inputId.val(" ");
                var spanDate = inputId.closest("#reportrangeallfilter").find('span');
                spanDate.html('');
            });
            window.location.href = window.location.origin + window.location.pathname;
        });

        if ( (performance.navigation.type == 1) && (performance.navigation.type == performance.navigation.TYPE_RELOAD ) )
            window.location.href = window.location.origin+window.location.pathname;


        $('#reportrangeallfilter').on('apply.daterangepicker', function(ev, picker) {
            if(picker.endDate.format('YYYY-MM-DD') =='Invalid date' && picker.startDate.format('YYYY-MM-DD') =='Invalid date' )
                $('#startDateSearchAll, #startDateSearchAll').val(null)
        });


    </script>
    @if(request('start_date') && request('end_date'))
        <script>
            $(document).ready(function (){
                let start =  "{{request('start_date')}}";
                let end =  "{{request('end_date')}}";
                $('#reportrangeallfilter span').html(moment(start).format('MMMM D, YYYY') + ' - ' + moment(end).format('MMMM D, YYYY'))
            })
        </script>
    @endif
    <script>
        $(document).ready(function (){
            $(document).keydown(function(e) {
                if (e.keyCode == 82 && e.ctrlKey || e.keyCode == 82 && e.ctrlKey && e.shiftKey || e.keyCode== 116	) {
                    e.preventDefault();
                    window.location.href = window.location.origin+window.location.pathname;
                }else if(event.which == 116 || event.keyCode == 116){
                    window.location.href = window.location.origin+window.location.pathname;
                }
            });
        })
    </script>



<script>
var tables = document.getElementsByClassName('resizable');
for (var i = 0; i < tables.length; i++) {
  resizableGrid(tables[i]);
}

function resizableGrid(table) {
  var row = table.getElementsByTagName('tr')[0],
    cols = row ? row.children : undefined;
  if (!cols) return;

  table.style.overflow = 'hidden';

  var tableHeight = table.offsetHeight;

  for (var i = 0; i < cols.length; i++) {
    var div = createDiv(tableHeight);
    cols[i].appendChild(div);
    cols[i].style.position = 'relative';
    setListeners(div);
  }

  function setListeners(div) {
    var pageX, curCol, nxtCol, curColWidth, nxtColWidth, tableWidth;

    div.addEventListener('mousedown', function(e) {

      tableWidth = document.getElementById('exampleTbl').offsetWidth;
      curCol = e.target.parentElement;
      nxtCol = curCol.nextElementSibling;
      pageX = e.pageX;

      var padding = paddingDiff(curCol);

      curColWidth = curCol.offsetWidth - padding;
      //  if (nxtCol)
      //nxtColWidth = nxtCol.offsetWidth - padding;
    });

    div.addEventListener('mouseover', function(e) {
      e.target.style.borderRight = '2px solid #0000ff';
    })

    div.addEventListener('mouseout', function(e) {
      e.target.style.borderRight = '';
    })

    document.addEventListener('mousemove', function(e) {
      if (curCol) {
        var diffX = e.pageX - pageX;

        // if (nxtCol)
        //nxtCol.style.width = (nxtColWidth - (diffX)) + 'px';

        curCol.style.width = (curColWidth + diffX) + 'px';
        console.log(curCol.style.width)
        console.log(tableWidth)
        document.getElementById('exampleTbl').style.width = tableWidth + diffX + "px"
      }
    });

    document.addEventListener('mouseup', function(e) {
      curCol = undefined;
      nxtCol = undefined;
      pageX = undefined;
      nxtColWidth = undefined;
      curColWidth = undefined
    });
  }

  function createDiv(height) {
    var div = document.createElement('div');
    div.style.top = 0;
    div.style.right = 0;
    div.style.width = '5px';
    div.style.position = 'absolute';
    div.style.cursor = 'col-resize';
    div.style.userSelect = 'none';
    div.style.height = height + 'px';
    return div;
  }

  function paddingDiff(col) {

    if (getStyleVal(col, 'box-sizing') == 'border-box') {
      return 0;
    }

    var padLeft = getStyleVal(col, 'padding-left');
    var padRight = getStyleVal(col, 'padding-right');
    return (parseInt(padLeft) + parseInt(padRight));

  }

  function getStyleVal(elm, css) {
    return (window.getComputedStyle(elm, null).getPropertyValue(css))
  }
};
    </script>




@endpush

