@extends('admin.dashboard.layouts.app')
@section('title','Company Details')
@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')
    <style>
        .btn-group, .btn-group-vertical{
            display: flex !important;
            margin-bottom: 10px !important;
            width: fit-content !important;
        }
        .card-title i{
            display: inline-block;
            background: #0b1426;
            color: #fff;
            padding: 9px 11px 9px 11px;
            border-radius: 2px;
        }
        .nav_center{
            justify-content: center;
        }
        .nav_main li{
            /* border-right: 1px solid #9ca6b9 !important; */
        }
        .nav_main li:last-child {
            border-right: none !important;
        }
        .nav-pills .nav-link.active{
            background-color: transparent !important;
            color: #000 !important;
            font-weight: bold !important;
        }
        .tab-content .count{
            min-height: 143px;
            border-radius: 4px;
            border: 1px solid #bed4ff;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .tab-content .count span{
            display: block;
            background: #0b1426;
            color: #fff;
            padding: 8px 0px 8px 0px;
            font-size: 16px;
            margin: 3px;
            border-radius: 4px;
        }
        .tab-content .count h5{
            margin-top: 33px;
            font-size: 26px;
        }
        /* .second_section{
            margin-top: 50px;
            margin-bottom: 50px;
        } */
        .scrape_data .main_data img{
            width: 100px;
            height: 100px;
            border: 1px solid #9ca6b9;
            border-radius: 50%;
            padding: 2px;
            display: inline-block;
        }
        .scrape_data .main_data .parent_names span{
            display: block;
        }
        .scrape_data .main_data{
            display: flex;
            justify-content: flex-start;
            gap: 12px;
        }
        .scrape_data .main_data .parent_names {
            padding-top: 26px;
        }
        #brand_campaigns_table tbody tr .style_td_action{
            display: flex;
            flex-direction: column;
        }
        .second_section .col-sm-6 > span{
            font-size: 13px !important;
            max-width: 150px;
            min-width: 150px;
            margin-right: 10px;
        }
        #sub_brand_modal .select2-container--default{
            width: 100%!important;
        }
        .img-flag{
            width: 20px!important;
        }
        .fav_name{
            word-break: break-all !important;
            font-size: 13px !important;
        }
        .card-header-brand-details ul#pills-tab li{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            gap: 0px;
        }
        .dataTables_length{
            position:static !important
        }

        #customSearch{
            border-radius: 2px;
            font-size: .825rem;
            background: #1A233A;
            color: #bcd0f7;
            border: none;
            padding: 5px;
            /*float:right;*/
        }
        .dataTables_length #customSearch {
            background: #292828 !important;
            border-color: #292828 !important;
            height: 35px;
            color: var(--second-color) !important;
            margin-left: 0.5em;
            display: inline-block;
            width: auto;
            border: 1px solid;
            border-radius: 2px;
            font-size: .825rem;
            padding: 0.25rem 0.5rem;
        }
        div#brand_campaigns_table_length {
            display: flex;
            justify-content: flex-start;
            flex-direction: column;
            width: 180px;
            gap: 0px;
            margin-bottom:5px
        }
        .status-active.text-inactive {
            background: #c16995  !important;
        }
        .status-active.text-active {
            background: #3b7f34 !important;
        }
    </style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Company Details'])
    <!-- /breadcrumb -->
@stop

@section('content')
    <div class="row row-sm">

        <div class="col-xl-12">
            <div class="mg-b-20">
                <div class="card-header pb-0 card-header-brand-details">
                    <div class="row">
                        <div class="col-12">
                        <div class="card" style="padding: 1rem 1rem;background: #1e1e1e;margin: 1rem 0rem;border-radius: 3px;position: relative;">

                            <div class="second_section text-left show-brand-details" style=" width: 100% !important; ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-8 col-12">
                                            
                                                    <div class="card">
                                                            <div class="overview_subBrand">
                                                            {{--  Image  --}}
                                                                <div class="information_brands">
                                                                    <img id="group_image" src="{{ $subbrand->image }}" alt="">
                                                                    <p> <span id="group_name">   {{ $subbrand->name }} </span> </p>
                                                                    <a href="{{route('dashboard.sub-brands.edit', $subbrand->id)}}" style="background-color: var(--button-bg-sec) !important;color: var(--second-color) !important;" class="edit_anchor btn hvr-sweep-to-right mt-1 mb-1 getSubbrandData"><i class="icon-edit-3" style="font-size: 20px;"></i>Edit</a>
                                                                </div>
                                                                {{--  Status, Phone And Gender  --}}
                                                                <div class="row mt-4">
                                                                    <div class="col-lg-3 col-md-4 mb-2">
                                                                        <div class="d-flex justify-content-start align-items-start flex-row information_brands_list" style="gap:20px">
                                                                            <span><i class="fa-solid fa-signal"></i>  Status: </span>
                                                                            <span id="group_status" class="status-active {{ $subbrand->status == 1 ? 'text-active' : 'text-inactive' }}">{{ $subbrand->status == 1 ? 'Active' : 'Inactive' }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 mb-2">
                                                                        <div class="d-flex justify-content-start align-items-start flex-row information_brands_list" style="gap:20px">
                                                                            <span><i class="fa-solid fa-phone"></i>  Phone: </span>
                                                                            <span id="group_phone">(+{{ $subbrand->code_phone ?? "--" }}) {{ $subbrand->phone ?? "--" }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 mb-2">
                                                                        <div class="d-flex justify-content-start align-items-start flex-row information_brands_list" style="gap:20px">
                                                                            <span><i class="fa-solid fa-person"></i>  Preferred Gender: </span>
                                                                            <span id="group_preferred_gender">{{ ucfirst($subbrand->preferred_gender) }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 mb-2">
                                                                        <div class="d-flex justify-content-start align-items-start flex-row information_brands_list" style="gap:20px">
                                                                            <p class="countries_list" id="group_country_code"><i class="fas fa-flag"></i>  Countries: </p>
                                                                            @foreach($subbrand->country_id as $country)
                                                                                @if($countryData = country($country))
                                                                                    {{ucfirst($countryData->name)}}
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 mb-2">
                                                                        <div class="d-flex justify-content-start align-items-start flex-row information_brands_list" style="gap:20px">
                                                                            <span><i class="fab fa-whatsapp"></i>  WhatsApp: </span>
                                                                            <span id="group_whats_number">(+{{ $subbrand->code_whats ?? "--" }}) {{ $subbrand->whats_number ?? "--" }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 mb-2">
                                                                        <div class="d-flex justify-content-start align-items-start flex-row information_brands_list" style="gap:20px">
                                                                            <span><i class="fas fa-calendar-week"></i>  Created At:  </span>
                                                                            <span id="group_created_at">{{ $subbrand->created_at }} </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 mb-2">
                                                                        <div class="d-flex justify-content-start align-items-start flex-row information_brands_list" style="gap:20px">
                                                                            <p class="d-flex"><i class="fas fa-hashtag mr-1"></i>  Platform:  </p>
                                                                            <ul class="list_accordion">
                                                                                @if(!is_null($subbrand->link_insta))
                                                                                    <li class="mb-1 _phone_table">
                                                                                        <i class="fab fa-instagram mr-1"></i> -
                                                                                        <a class="text-white ml-1" target="_blank" href="{{"https://www.instagram.com/".$subbrand->link_insta}}" id="group_link_insta">{{ $subbrand->link_insta }}</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(!is_null($subbrand->link_facebook))
                                                                                    <li class="mb-1 _phone_table">
                                                                                        <i class="fab fa-facebook-square mr-1"></i> -
                                                                                        <a class="text-white ml-1" target="_blank" href="{{"https://www.facebook.com/".$subbrand->link_facebook}}" id="group_link_facebook">{{ $subbrand->link_facebook }}</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(!is_null($subbrand->link_tiktok))
                                                                                    <li class="mb-1 _phone_table">
                                                                                        <i class="fab fa-tiktok mr-1"></i> -
                                                                                        <a class="text-white ml-1" target="_blank" href="{{"https://www.tiktok.com/@".$subbrand->link_tiktok}}" id="group_link_tiktok">{{ $subbrand->link_tiktok }}</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(!is_null($subbrand->link_snapchat))
                                                                                    <li class="mb-1 _phone_table">
                                                                                        <i class="fab fa-snapchat-square mr-1"></i> -
                                                                                        <a class="text-white ml-1" target="_blank" href="{{"https://story.snapchat.com/@".$subbrand->link_snapchat}}" id="group_link_snapchat">{{ $subbrand->link_snapchat }}</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(!is_null($subbrand->link_website))
                                                                                    <li class="mb-1 _phone_table">
                                                                                        <i class="fas fa-globe mr-1"></i> -
                                                                                        <a class="text-white ml-1" target="_blank" href="{{$subbrand->link_website}}" id="group_link_website">{{ $subbrand->link_website }}</a>
                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                        
                                           
                                            <div class="col-lg-4 col-md-8 col-12">
                                                <div class="grand-subbrand-info-box">
                                                    <a href="{{route('dashboard.sub-brands.edit', $subbrand->id)}}"  class="edit_anchor btn hvr-sweep-to-right mt-1 mb-1 getSubbrandData edit-sub-brand-link"><i class="icon-edit-3" style="font-size: 20px;"></i>Edit</a>
                                                    <div class="img-name-box">
                                                        <img src="{{ $subbrand->image }}" alt="{{ $subbrand->image }}" class="img-fluid">
                                                        <div class="name-box">
                                                            <h3 class="name-item">
                                                                {{ $subbrand->name }}
                                                            </h3>
                                                            <div class="status-box status-active {{ $subbrand->status == 1 ? 'text-active' : 'text-inactive' }}">{{ $subbrand->status == 1 ? 'Active' : 'Inactive' }}</div>
                                                        </div>
                                                    </div>
                                                               <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-12 pt-3">
                                                                        <div class="information_brands_list" style="gap:20px">
                                                                            <span class="list-name"><i class="fa-solid fa-phone"></i>  Phone: </span>
                                                                            <span id="group_phone">(+{{ $subbrand->code_phone ?? "--" }}) {{ $subbrand->phone ?? "--" }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-12 pt-3">
                                                                        <div class="information_brands_list" style="gap:20px">
                                                                            <span class="list-name"><i class="fa-solid fa-person"></i>  Preferred Gender: </span>
                                                                            <span id="group_preferred_gender">{{ ucfirst($subbrand->preferred_gender) }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-12 pt-3">
                                                                        <div class="information_brands_list" style="gap:20px">
                                                                            <p class="countries_list list-name" id="group_country_code"><i class="fas fa-flag"></i>  Countries: </p>
                                                                            @foreach($subbrand->country_id as $country)
                                                                                @if($countryData = country($country))
                                                                                    {{ucfirst($countryData->name)}}
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-12 pt-3">
                                                                        <div class="information_brands_list" style="gap:20px">
                                                                            <span class="list-name"><i class="fab fa-whatsapp"></i>  WhatsApp: </span>
                                                                            <span id="group_whats_number">(+{{ $subbrand->code_whats ?? "--" }}) {{ $subbrand->whats_number ?? "--" }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-12 pt-3">
                                                                        <div class="information_brands_list" style="gap:20px">
                                                                            <span class="list-name"><i class="fas fa-calendar-week"></i>  Created At:  </span>
                                                                            <span id="group_created_at">{{ $subbrand->created_at }} </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-12 pt-3">
                                                                        <div class="information_brands_list" style="gap:20px">
                                                                            <p class="list-name"> <i class="fas fa-hashtag mr-1"></i>  Platform:  </p>
                                                                            <ul class="list_accordion">
                                                                                @if(!is_null($subbrand->link_insta))
                                                                                    <li class="mb-1 _phone_table">
                                                                                        <i class="fab fa-instagram mr-1"></i> -
                                                                                        <a class="text-white ml-1" target="_blank" href="{{"https://www.instagram.com/".$subbrand->link_insta}}" id="group_link_insta">{{ $subbrand->link_insta }}</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(!is_null($subbrand->link_facebook))
                                                                                    <li class="mb-1 _phone_table">
                                                                                        <i class="fab fa-facebook-square mr-1"></i> -
                                                                                        <a class="text-white ml-1" target="_blank" href="{{"https://www.facebook.com/".$subbrand->link_facebook}}" id="group_link_facebook">{{ $subbrand->link_facebook }}</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(!is_null($subbrand->link_tiktok))
                                                                                    <li class="mb-1 _phone_table">
                                                                                        <i class="fab fa-tiktok mr-1"></i> -
                                                                                        <a class="text-white ml-1" target="_blank" href="{{"https://www.tiktok.com/@".$subbrand->link_tiktok}}" id="group_link_tiktok">{{ $subbrand->link_tiktok }}</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(!is_null($subbrand->link_snapchat))
                                                                                    <li class="mb-1 _phone_table">
                                                                                        <i class="fab fa-snapchat-square mr-1"></i> -
                                                                                        <a class="text-white ml-1" target="_blank" href="{{"https://story.snapchat.com/@".$subbrand->link_snapchat}}" id="group_link_snapchat">{{ $subbrand->link_snapchat }}</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(!is_null($subbrand->link_website))
                                                                                    <li class="mb-1 _phone_table">
                                                                                        <i class="fas fa-globe mr-1"></i> -
                                                                                        <a class="text-white ml-1" target="_blank" href="{{$subbrand->link_website}}" id="group_link_website">{{ $subbrand->link_website }}</a>
                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
                        <div class="col-12">
                
                                <div class="card">
                                    <ul class="nav nav_center nav_main nav-pills" id="pills-tab" role="tablist">

                                        @can('branches brands_buttons')
                                            <li class="nav-item">
                                                <a class="nav-link active pills-branches-tab" id="pills-branches-tab" data-toggle="pill" href="#pills-branches" role="tab" aria-controls="pills-branches" aria-selected="false">Branches <span></span></a>
                                            </li>
                                        @endcan
                                        @if($brand->status != 2)
                                            @can('wishlist brands_buttons')
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-influs-tab" data-toggle="pill" href="#pills-influs" role="tab" aria-controls="pills-influs" aria-selected="false">Wishlist <span></span></a>
                                                </li>
                                            @endcan
                                            @can('campaigns brands_buttons')
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-camps-tab" data-toggle="pill" href="#pills-camps" role="tab" aria-controls="pills-camps" aria-selected="true">Campaigns <span></span></a>
                                                </li>
                                            @endcan

                                            @can('wishlist brands_buttons')
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-unfavorite-tab" data-toggle="pill" href="#pills-unfavorite" role="tab" aria-controls="pills-unfavorite" aria-selected="false">Unfavorite <span></span></a>
                                                </li>
                                            @endcan


                                        @endif
                                    </ul>
                                <div class="grand-filter-box-brand">
                                        <div class="tab-content" id="pills-tabContent">

                                        <input type="hidden" id="route_sub_brand_id" value="{{$subbrand->id}}" />

                                            <div class="tab-pane fade active show" id="pills-branches" role="tabpanel" aria-labelledby="pills-branches-tab">
                                                @include('admin.dashboard.brands.profile.branches')
                                            </div>

                                            @if($brand->status != 2)
                                            <div class="tab-pane fade" id="pills-camps" role="tabpanel" aria-labelledby="pills-camps-tab">
                                                @include('admin.dashboard.brands.profile.campaigns')
                                            </div>

                                            <div class="tab-pane fade" id="pills-influs" role="tabpanel" aria-labelledby="pills-influs-tab">
                                                <div class="fifth">
                                                    <div class="row">
                                                            @include('admin.dashboard.brands.profile.group_list')
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="pills-unfavorite" role="tabpanel" aria-labelledby="pills-unfavorite-tab">
                                                <div class="fifth">
                                                    <div class="row">
                                                        @include('admin.dashboard.brands.profile.unfavorite')
                                                    </div>
                                                </div>
                                            </div>


                                            @endif
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
    </div>

@endsection

@section('js')
    @include('admin.dashboard.layouts.includes.general.scripts.index')
    <!--Internal  Chart.bundle js -->
        <script src="{{asset('js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('js/campaign/index.js')}}"></script>
        <script src="{{asset('js/influencer/list.js')}}"></script>
        <script src="{{asset('js/influencer/branches_crud.js')}}"></script>

 <script>
     let brand_branches_table=null;
     let brand_campaigns_table=null ;
    $(document).ready(function () {

		$(".select2").select2();
	});
	</script>
@endsection




