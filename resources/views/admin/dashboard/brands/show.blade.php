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

      .error, #groupname-error, #account_user_login_id-error, #hidden_id-error, #flag-error, #sub_brand_id-error, #country_id_group-error, #sub_brand_id-error, #symbol-error {
          color: red !important;
          font-size: small !important;
      }

      #influe_group_list_wrapper {
          padding-block: 60px !important;
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
                            <div class="d-flex justify-content-between" style=" display: flex; align-items: center !important; justify-content: center !important;flex-direction: column !important; gap: 8px ">
                                <img src="{{ isset($brand) && !empty($brand->image) ? $brand->image : '/assets/img/avatar_logo.png' }}" id="imgLogo" alt="" width="50" height="50">
                                <h4 class="card-title mt--1" style=" display: flex; flex-direction: column; align-items: center; gap: 10px; text-transform: capitalize; "> {{$brand->name}} </h4>
                            </div>
                            <div class="userName_Opitions" style=" display: flex; align-items: center; justify-content: center; ">
                                <div class="opition">
                                    @can('update brands')
                                    <a data-toggle="tooltip" data-placement="top" title="Edit Brand" class="hvr-sweep-to-right editRow" href="{{route('dashboard.brands.edit', $brand->id)}}" class="btn mt-2 mb-2" ><i class="fa fa-edit"></i> Edit</a>
                                    @endcan
                                    @if($brand->status == 2 || $brand->status == 3 || $brand->status == 0 || $brand->status != 1)
                                        <button data-toggle="tooltip" data-placement="top" title="Active Brand" @if(!($brand->whatsapp && $brand->insta_uname)) disabled @endif data-flag="active" class="btn mt-2 mb-2 acceptRow hvr-sweep-to-right" id="accept-{{$brand->id}}" data-id="{{$brand->id}}" ><i class="icon-toggle-right"></i> Active </button>
                                        @if($brand->status != 2 && $brand->status != 3)
                                        <button data-toggle="tooltip" data-placement="top" title="Reject Brand" class="btn mt-2 mb-2 rejectRow hvr-sweep-to-right" @if($brand->status == 3) disabled @endif data-flag="reject" id="accept-{{$brand->id}}" data-id="{{$brand->id}}"><i class="fa fa-times-circle"></i> Reject</button>
                                        @endif
                                    @else
                                        <button data-toggle="tooltip" data-placement="top" title="Inactive Brand" class="btn mt-2 mb-2 InAcceptRow hvr-sweep-to-right" data-flag="inactive" id="inactive-{{$brand->id}}" data-id="{{$brand->id}}" ><i class="icon-toggle-left"></i> Inactivate </button>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="second_section text-left show-brand-details" style=" width: 100% !important; ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- <h5 class="mb-6">{{@$brand->name}} Details</h5> -->
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 mb-2">
                                                <div class="d-flex justify-content-start align-items-start flex-row brand-det-row" style="gap:20px">
                                                    <span><i class="fa-solid fa-signature"></i>  Company Username : </span>
                                                    <span>{{@$brand->user->user_name}}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 mb-2">
                                                <div class="d-flex justify-content-start align-items-start flex-row brand-det-row" style="gap:20px">
                                                    <span><i class="fa-solid fa-signature"></i> Company Name : </span>
                                                    <span>{{@$brand->name}}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 mb-2">
                                                <div class="d-flex justify-content-start align-items-start flex-row brand-det-row" style="gap:20px">
                                                    <span><i class="fa-solid fa-envelope"></i> Email : </span>
                                                    <span>{{@$brand->user->email}}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 mb-2">
                                                <div class="d-flex justify-content-start align-items-start flex-row brand-det-row" style="gap:20px">
                                                    <span><i class="fa-solid fa-phone"></i> Main Phone Number : </span>
                                                    <span>(+{{$brand->user->code??"--"}}) {{$brand->user->phone ?? "--"}}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 mb-2">
                                                <div class="d-flex justify-content-start align-items-start flex-row brand-det-row" style="gap:20px">
                                                    <span><i class="fa-brands fa-whatsapp"></i> WhatsApp Phone Number : </span>
                                                    <span>(+{{@$brand->whatsapp_code??"--"}}) {{@$brand->whatsapp ?? "--"}}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 mb-2">
                                                <div class="d-flex justify-content-start align-items-start flex-row brand-det-row" style="gap:20px">
                                                        <span> <i class="fa-solid fa-signal"></i> Status : </span>
                                                        @if($brand->status == 1)
                                                            <span class="badge badge-pill badge-success status-active" style="min-width: 59px !important;">Active</span>
                                                        @elseif($brand->status == 2)
                                                            <span class="badge badge-pill status-inActive" style="min-width: 59px !important;background-color:#e57c8f !important">InActive</span>
                                                        @elseif($brand->status == 3)
                                                            <span class="badge badge-pill badge-danger status-reject" style="min-width: 59px !important;">Rejected</span>
                                                        @elseif($brand->status == 0)
                                                            <span class="badge badge-pill badge-info status-pending" style="min-width: 59px !important;">Pending</span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 mb-2">
                                                <div class="d-flex justify-content-start align-items-start flex-row brand-det-row" style="gap:20px">
                                                    <span> <i class="fa-solid fa-flag"></i> Countries : </span>
                                                        @foreach($countries_id as $country)
                                                            <span class="_country_table">{{ucfirst($country->name)}}</span>
                                                        @endforeach
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                    </div>
                        </div>
                        <div class="col-12">
                            <div class="card">

                            <ul class="nav nav_center nav_main nav-pills" id="pills-tab" role="tablist">
                                @can('groupOfBrand brands_buttons')
                                    <li class="nav-item">
                                        <a class="nav-link active pills-subbrand-tab" id="pills-subbrand-tab" data-toggle="pill" href="#pills-subbrand" role="tab" aria-controls="pills-subbrand" aria-selected="false">Brands <span></span></a>
                                    </li>
                                @endcan
                                @can('branches brands_buttons')
                                    <li class="nav-item">
                                        <a class="nav-link  pills-branches-tab" id="pills-branches-tab" data-toggle="pill" href="#pills-branches" role="tab" aria-controls="pills-branches" aria-selected="false">Branches <span></span></a>
                                    </li>
                                @endcan
                                @if($brand->status != 0)
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

                                    @can('dislike brands_buttons')
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-deslike-tab" data-toggle="pill" href="#pills-deslike" role="tab" aria-controls="pills-deslike" aria-selected="false">Disliked <span></span></a>
                                        </li>
                                    @endcan
                                    <li class="nav-item" style="display: none;">
                                        <a class="nav-link" id="pills-report-tab" data-toggle="pill" href="#pills-report" role="tab" aria-controls="pills-report" aria-selected="false">Report</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#pills-setting" role="tab" aria-controls="pills-setting" aria-selected="false">Setting</a>
                                    </li> -->
                                @endif
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade  text-center" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab">
                                    <div class="userName_Opitions">
                                        <div class="opition">
                                            @can('update brands')
                                            <a data-toggle="tooltip" data-placement="top" title="Edit Brand" href="{{route('dashboard.brands.edit', $brand->id)}}" class="btn mt-2 mb-2" ><i class="fa fa-edit"></i> Edit</a>
                                            @endcan
                                            @if($brand->status == 2 || $brand->status == 3 || $brand->status == 0 || $brand->status != 1)
                                                <button data-toggle="tooltip" data-placement="top" title="Active Brand" @if(!($brand->whatsapp && $brand->insta_uname)) disabled @endif data-flag="active" class="btn mt-2 mb-2 acceptRow" id="accept-{{$brand->id}}" data-id="{{$brand->id}}" ><i class="icon-toggle-right"></i> Active </button>
                                                @if($brand->status != 2 && $brand->status != 3)
                                                <button data-toggle="tooltip" data-placement="top" title="Reject Brand" class="btn mt-2 mb-2 rejectRow" @if($brand->status == 3) disabled @endif data-flag="reject" id="accept-{{$brand->id}}" data-id="{{$brand->id}}"><i class="fa fa-times-circle"></i> Reject</button>
                                                @endif
                                            @else
                                                <button data-toggle="tooltip" data-placement="top" title="Inactive Brand" class="btn mt-2 mb-2 InAcceptRow" data-flag="inactive" id="inactive-{{$brand->id}}" data-id="{{$brand->id}}" ><i class="icon-toggle-left"></i> Inactivate </button>
                                            @endif
                                        </div>

                                    </div>

                                    <hr>
									<input type="text" id="brand_id" value="{{$brand->id}}" />
									<input type="text" id="route_sub_brand_id" value="0" />
                                    <div class="second_section text-left show-brand-details" style=" width: 100%; ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="mb-6">{{@$brand->name}} Details</h5>
                                                <div class="row">
                                                    <div class="col-12 mb-2">
                                                        <span class="">Brand Username : </span>
                                                        <span>{{@$brand->user->user_name}}</span>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <span class="">Brand Name : </span>
                                                        <span>{{@$brand->name}}</span>
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <span class=""> Email : </span>
                                                        <span>{{@$brand->user->email}}</span>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <span class=""> Main Phone Number : </span>
                                                        <span>{{@$brand->user->phone}}</span>
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <span class=""> WhatsApp Phone Number : </span>
                                                        <span>{{@$brand->whatsapp}}</span>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <span class=""> Status : </span>
                                                        @if($brand->status == 1)
                                                            <span class="badge badge-pill badge-success" style="min-width: 59px !important;">Active</span>
                                                        @elseif($brand->status == 2)
                                                            <span class="badge badge-pill" style="min-width: 59px !important;background-color:#e57c8f !important">InActive</span>
                                                        @elseif($brand->status == 3)
                                                            <span class="badge badge-pill badge-danger" style="min-width: 59px !important;">Rejected</span>
                                                        @elseif($brand->status == 0)
                                                            <span class="badge badge-pill badge-info" style="min-width: 59px !important;">Pending</span>
                                                        @endif
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <span class=""> Countries : </span>
                                                            @foreach($countries_id as $country)

                                                                <span>{{ucfirst($country->code)}}</span>
                                                            @endforeach
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                </div>


                                <div class="tab-pane fade active show" id="pills-subbrand" role="tabpanel" aria-labelledby="pills-subbrand-tab">
                                     @include('admin.dashboard.brands.profile.subbrands')
                                </div>

                                <div class="tab-pane fade " id="pills-branches" role="tabpanel" aria-labelledby="pills-branches-tab">
                                     @include('admin.dashboard.brands.profile.branches')
                                </div>

                                @if($brand->status != 0)
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

                                <div class="tab-pane fade" id="pills-deslike" role="tabpanel" aria-labelledby="pills-deslike-tab">
                                    <div class="fifth">
                                        <div class="row">
                                             @include('admin.dashboard.brands.profile.dislike')
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" style="display: none" id="pills-report" role="tabpanel" aria-labelledby="pills-report-tab">
                                    <div clss="row">
                                        <div class="col-sm-6">
                                            <h5 style="text-align: left !important;">Report</h5>
                                            <p style="text-align: left !important;">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-setting" role="tabpanel" aria-labelledby="pills-setting-tab">
                                    <div class="fifth">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                                    <label class="form-check-label" for="defaultCheck2">
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                                                    <label class="form-check-label" for="defaultCheck3">
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck4">
                                                    <label class="form-check-label" for="defaultCheck4">
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck5">
                                                    <label class="form-check-label" for="defaultCheck5">
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck6">
                                                    <label class="form-check-label" for="defaultCheck6">
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endif
                            </div>
                         </div>
                        </div>
                    </div>
                 <div class="card-body">

                </div>

            </div>
        </div>
    </div>




        {{--  statrt modal delete all campaigns   --}}
            <div class="modal fade" id="delete_all_camps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                            Delete Campaigns
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <h6 style="color: #fff;"> Are You Sure ? </h6>
                        <input class="text" type="hidden" id="delete_all_id_camps" name="delete_all_id_camps" value=''>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn Delete hvr-sweep-to-right"
                                data-dismiss="modal">Close</button>
                        <button type="button" id="submit_delete_all_camps" class="btn Active hvr-sweep-to-right">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        {{--  end modal delete all campaigns   --}}

        @include('admin.dashboard.brands.models.import_excel')
        @include('admin.dashboard.layouts.includes.general.models.expiration_date_model')

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
     let subBrandTbl=null ;
    $(document).ready(function () {

		$(".select2").select2();
        // accept row
        $(document).on('click','.acceptRow',function (){
            $('#expre_date_err').hide();
            $('#expre_date_err').text('');
            let id = $(this).data('id');
            let data_flag = $(this).data('flag');
            $('#add_expiration_date').modal('show');
            $(document).on('click','#active_user',function (){
                swalAccept(id,data_flag);
            });
        });

        //inaccept row
        $(document).on('click','.InAcceptRow',function (){
            console.log('InAcceptRow');
            let id = $(this).data('id');
            let data_flag = $(this).data('flag');
            swalAccept(id,data_flag);
        });

        //reject Row
        $(document).on('click','.rejectRow',function (){
            let id = $(this).data('id');
            let data_flag = $(this).data('flag');
            swalAccept(id,data_flag);
        });

        //swal to do three actions (acceptRow,InAcceptRow,rejectRow)
        function swalAccept(id,data_flag){
            let accetp_swal = Swal.fire({
                title: "Are you sure you want to "+ data_flag +"",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: data_flag,
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(function (result){
                if (result.isConfirmed){
                    let expire_date = ($('#expire_date_input').val() != '' && $('#expire_date_input').val() != null) ? $('#expire_date_input').val() : -1;
                    $.ajax({
                        url:`/dashboard/brand-accept/${id}`,
                        type:'post',
                        data:{expire_date,data_flag},
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        success:(data)=>{
                            if(data.status){
                                // $('.acceptRow').attr("disabled", 'disabled');
                                $('.fa-circle').addClass('active')
                                $('.fa-circle').attr('title', 'Active')
                                $('.fa-circle').attr('data-original-title', 'Active')
                                $('#add_expiration_date').modal('hide')
                                $('#expire_date_input').val('')
                                Swal.fire("accepted!",data.message, "success");
                                location.reload();
                            }else{
                                Swal.fire.close();
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
                    $('#expire_date_input').val('')
                    Swal.fire("Canceled", "Canceled Successfully!", "error");
                }
            })
        }

        $(document).ready(function() {


            $(document).on('change', "select[name='country_id_search_camps[]']", function() {
                var sono = $('.country_id_search_camps').select2({
                    multiple:true,
                })
            })
        });

        $('#status_id_search,#country_id_search,#subbrand_country_id,#subbrand_preferred_gender, #subbrand_branch_ids').select2({
            placeholder: "Select",
            allowClear: true
        });

        function swalDel_camp(id, tabel ){
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(function (result){
                if (result.isConfirmed){
                    let reqUrl = ``;
                    if(typeof id == "string")
                        reqUrl = `/dashboard/campaigns/${id}`;
                    else if(typeof id == "object")
                        reqUrl = `/dashboard/campaigns/bulk/delete`;
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
                            Swal.fire("error", "something went wrong please reload page", "error");
                        }
                    })
                } else {
                    Swal.fire("Canceled", "canceled successfully!", "error");
                }
            })
        }
        $(document).on('click','.delRow_camp',function (){
            swalDel_camp($(this).attr('data-id'), brand_campaigns_table);
        });

        //TO SELECT ALL CAMPS
        $(document).on('click','#select_all_camp',function (){
            CheckAll('box1_camps',this);
        });
       //Clear check all after change page


        //DELETE ALL campaigns (GET IDS OF SELECTED BRANDS)
        $(document).on('click','#btn_delete_all_camp',function (){
            var selected_2 = new Array();
            $("#brand_campaigns_table input[type=checkbox]:checked").each(function() {
                if(this.value != 'on'){
                    selected_2.push(this.value);
                }
            });
            if (selected_2.length > 0) {
                console.log(selected_2)
                $('#delete_all_camps').modal('show')
                $('input[id="delete_all_id_camps"]').val(selected_2);
            }else{
                Swal.fire("Canceled", "Please Select Campaigns!", "warning");
            }
        });


        //SUBMIT DELETE ALL TO SELECTED camp
        $(document).on('click','#submit_delete_all_camps',function (){
            let selected_ids =  $('input[id="delete_all_id_camps"]').val();
            $.ajax({
                type: 'delete',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: '{{route('dashboard.campaigns.delete_all')}}',
                data: {selected_ids:selected_ids},
                dataType: 'json',
                success: function (data) {
                    if(data.status){
                        $('#delete_all_camps').modal('hide')
                        brand_campaigns_table.clear();
                        brand_campaigns_table.ajax.reload();
                        Swal.fire("Deleted!", "Deleted Successfully!", "success");
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

    function CheckAll(className, elem) {
        var elements = document.getElementsByClassName(className);
        var l = elements.length;
        if (elem.checked) {
            for (var i = 0; i < l; i++) {
                elements[i].checked = true;
            }
        } else {
            for (var i = 0; i < l; i++) {
                elements[i].checked = false;
            }
        }
    }


    //TO SELECT ALL
    $(document).on('click','#select_all',function (){
        CheckAll('select_all_subbrand',this);
    });

    });
    function format(item, state) {
        if (!item.id) {
            return item.text;
        }
        var flag= item.element.attributes[1];
        var countryUrl = "https://hatscripts.github.io/circle-flags/flags/";
        var url = state ? stateUrl : countryUrl;
        var img = $("<img>", {
            class: "img-flag-all",
            width: 18,
            src: url + flag.value.toLowerCase() + ".svg"
        });
        var span = $("<span>", {
            text: " " + item.text
        });
        span.prepend(img);
        return span;
    }
    function formatState (state) {
        if (!state.id) {
            return state.text;
        }
        var flag= state.element.attributes[1].value;
        var baseUrl = "https://hatscripts.github.io/circle-flags/flags/";
        var $state = $(
            '<span><img class="img-flag" width="22"/> <span></span></span>'
        );
        $state.find("img").attr("src", baseUrl + "/" + flag.toLowerCase() + ".svg");
        return $state;
    };
    function selectCountry(){
        $('.country_code').select2({
            placeholder: "🌍 Global",
            allowClear: true,
            templateResult: function(item) {
                return format(item, false);
            },
            templateSelection:function(state) {
                return formatState(state, false);
            },
        });
    }selectCountry()

    </script>

    @if(session()->has('successful_message'))
        <script>
            Swal.fire("Good job!", "{{session()->get('successful_message')}}", "success");
        </script>
    @elseif(session()->has('error_message'))
        <script>
            Swal.fire("Good job!", "{{session()->get('error_message')}}", "error");
        </script>
    @endif


@endsection


