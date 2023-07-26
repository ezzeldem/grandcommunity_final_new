@extends('admin.dashboard.layouts.app')
@section('title','Campaign Details')
@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')
    <link href="{{asset('css/custom-style.css')}}" rel="stylesheet">
    <link href="{{asset('css/campaign.css')}}" rel="stylesheet">
    <style>
        #dataAppend{
            width: 100%;
        }
        .btn_table #custom{
            display: none;
        }
        #DTE_Field_branches ,#DTE_Field_confirmation_date,#DTE_Field_coverage_date,#DTE_Field_branches_date,#DTE_Field_date,#DTE_Field_brief,#DTE_Field_rate,#DTE_Field_comment_rate{
            border: 1px solid #596280;
            border-radius: 7px;
            font-size: .825rem;
            background: #1A233A;
            color: #bcd0f7;
            height: 27px;
            width: 268px !important;
        }
        .buttons-colvis{
            display: block !important;
        }
        .DTE_Bubble_Liner{
            background: #0d0d0d !important;
        }
        .DTE_Form_Buttons .btn{
            background: #161616 !important;
            border: 12px !important;
        }
   #DataTables_Table_0_paginate{
       display: none;
   }
   #DataTables_Table_0_wrapper table thead{
       display: none;
   }
        #exampleTbl_length{
            display: contents;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
        }


        #custom {
            border-radius: 2px;
            font-size: .825rem;
            background: #1A233A;
            color: #bcd0f7;
            border: none;
            padding: 5px;
            /*float:right;*/
        }
    </style>
@endsection
@section('content')
    @php
        $routes =  [['route'=>route('dashboard.campaigns.index'),'name'=>'Campaign']];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb',$routes)
    <div class="row gutters">
        <div class="card" style="flex: 1 1 auto;">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">@yield('title')</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <a href="{{route('dashboard.campaigns.index')}}" class="btn mt-2 mb-2 pb-2"><i class="icon-navigate_before"></i> Back </a>
            </div>
            <div class="card-body">
                <div class="top-content">
                    <div class="camp-top">
                        <div class="">
                            <div class="camp-top-inner row">
                                <div class="campaign_details_parent col-md-7">
                                    <div class="campaign_name campaign_details">
                                        <h6>Campaign Name : </h6>
                                        <span>{{$campaign->name}}</span>
                                    </div>
                                    <div class="brand_name campaign_details">
                                        <h6>Brand Name : </h6>
                                        <span>{{$brand->name}}</span>
                                    </div>
                                    <div class="type campaign_details">
                                        <h6>Type : </h6>
                                        <span class="badge badge-pill badge-info" style="max-width:fit-content">{{ array_key_exists($campaign->campaign_type, campaignType())?  campaignType()[$campaign->campaign_type] : '' }} </span>
                                    </div>
                                    <div class="gender campaign_details">
                                        <h6>Campaign Preferred Gender : </h6>
                                        <span class="badge badge-pill badge-purple" style="max-width:fit-content">{{$campaign->gender}} </span>
                                    </div>

                                    @if($campaign->campaign_type==2 || $campaign->campaign_type==0)
                                        <div class="visit_date campaign_details">
                                            <h6> Visit Date :  </h6>
                                            <span>  {{$campaign->visit_start_date}}  /  {{$campaign->visit_end_date}} </span>
                                        </div>
                                    @endif
                                    @if($campaign->campaign_type==2 || $campaign->campaign_type==1)
                                        <div class="delivery_date campaign_details">
                                            <h6> Delivery Date : </h6>
                                            <span>  {{$campaign->deliver_start_date}}  /  {{$campaign->deliver_end_date}} </span>
                                        </div>
                                    @endif

                                    <div class="countries campaign_details">
                                        <h6>Countries:</h6>
                                        @foreach($countries as $country)
                                            <img style="display: inline-block;margin-bottom: 2px;" src="https://hatscripts.github.io/circle-flags/flags/{{\Illuminate\Support\Str::lower($country->code)}}.svg" width="26" class="img-flag">
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" id="getCampStatus" value="3">
                                <div class="secret_key_card col-md-5">

                                    @can('update campaigns')
                                        <div class="d-flex justify-content-center" style="gap: 5px">
                                            <select class="form-control select2" required id="camp_status_val" name="status">
                                                <option selected disabled>Select </option>
                                                @foreach(campaignStatusData() as $status)
                                                    <option value="{{$status->value}}" @if($status->value == $campaign->status) selected @endif>{{$status->name}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="campaign_status_is" name="id" value="{{$campaign->id}}">
                                            <button class="btn" id="changeStatus">Update</button>
                                        </div>
                                    @endcan
                                    <div class="secrets">
                                        <div class="card " style="">
                                            <div class="card-body text-info" style="padding: 5px">
                                                <div class="card-header d-flex justify-content-around mb-3">
                                                    <h5 class="card-title">Secret Key:</h5>
                                                </div>
                                                <div class="secret-container">
                                                    <ul>
                                                        @foreach($secrets as $secret)
                                                            <li class="mb-3">
                                                                <div class="copy-text-area d-flex align-items-center justify-content-between" >
                                                                    <input style="background: #1a233a;color: white;" readonly="" id="secretKey_{{$secret->id}}" value="{{$secret->secret}}"/>
                                                                    <button title="copy" class="" onclick="copyElementToClipboard('#secretKey_{{$secret->id}}')"><i class="fa fa-clone"></i></button>
                                                                    <label class="switch">
                                                                        <input type="checkbox" name="active_secret_{{$secret->id}}" value="{{$secret->is_active}}" @if(!empty(old('active_secret_'.$secret->id)) && old('active_secret_'.$secret->id) == $secret->is_active)  checked @endif @if($secret->is_active) checked @endif id="active_secret_{{$secret->id}}" onChange="updateSecret('{{$secret->id}}')">
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                    <button title="delete" class="delete_secret_btn" onclick="deleteSecretKey('#secretKey_{{$secret->id}}', '{{$secret->id}}')"><i class="fas fa-trash-alt"></i></button>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="d-flex justify-content-end compare-btns" style="gap: 5px">
                                @can('update campaigns')
                                    <a href="{{route('dashboard.campaigns.edit', $campaign->id)}}" class="btn pb-2">
                                        <i class="far fa-edit"></i> Edit
                                    </a>
                                @endcan
                                <a href="{{route('dashboard.campaigns.log', $campaign->id)}}" class="btn pb-2">
                                    <i class="far fa-font-awesome-logo-full"></i> Campaign Log
                                </a>
                                <a class="btn pb-2"
                                   data-toggle="modal"  data-target="#add_influecer_modal">
                                    <i class="fa fa-users"></i> Add Influencer
                                </a>
                                    <a class="btn pb-2"
                                       data-toggle="modal" id="import_excel_addInfluencer"  data-target="#import_excel" data_url="{{route('dashboard.camp.addInfluencer.import')}}">
                                        <i class="fa fa-users"></i> Import
                                    </a>

                                    <a class="btn pb-2" id="coverage_camp_modal"
                                       data-toggle="modal"  data-target="#coverage_camp"
                                      @if($campaign->campaign_type==0||$campaign->campaign_type==2)
                                       data-visit-coverage="{{$campaign->visit_coverage}}"
                                       data-visit-confiramtion="{{$campaign->confirmation_link}}"
                                       @endif
                                       @if($campaign->campaign_type==1||$campaign->campaign_type==2)
                                       data-delivery-confiramtion="{{$campaign->confirmation_delivery_link}}"
                                       data-delivery-coverage="{{$campaign->delivery_coverage}}"
                                       @endif
                                    >
                                        Coverage
                                    </a>

                                {{--  @can('delete campaigns')
                                    <button class="btn btn-danger " id="deleteCamp">
                                        <i class="far fa-trash-alt"></i> Delete
                                    </button>
                                @endcan  --}}
                            </div>

                        </div>
                    </div>
                    <div class="cam_all_data">
                        <div>
                            <div class="row m-2">
                                <div class="col-md-6 col-lg-12 col-sm-4 mt-3 mb-3 d-flex justify-content-center" style="gap: 10px">
                                    <!-- App actions start -->
                                    <div class="app-actions">
                                        {{--  @dd($campaign)  --}}
                                        <button type="button" class="btn">Total Target :  <span style="border-radius: 23px;margin-left: 10px;" class="badge badge-info"> {{$campaign->influencer_count}}</span></button>
                                        {{--  <button type="button" class="btn">Total Influencers in List :<span style="border-radius: 23px;margin-left: 10px;" class="badge badge-info"> {{$list_count}}</span></button>  --}}
                                        <button type="button" class="btn">Total Influencers in List :<span style="border-radius: 23px;margin-left: 10px;" class="badge badge-info"> {{$campaign->campaignInfluencers->count()}}</span></button>
                                        <button type="button" class="btn">Target Per Day :  <span style="border-radius: 23px;margin-left: 10px;" class="badge badge-info"> {{$campaign->influencer_per_day}}</span></button>
                                        <button type="button" class="btn">Total Confirmations  : <span style="border-radius: 23px;margin-left: 10px;" class="badge badge-info"> {{$total_confirmations}}</span></button>
                                        <button type="button" class="btn active">Total Rejections  : <span style="border-radius: 23px;margin-left: 10px;" class="badge badge-info"> {{$total_refused}}</span></button>
                                    </div>
                                </div>
                                <div class="col-md-12 pt-5">
                                    <div id="accordion">
                                        <div class="navDiv" >
                                            <button class="btn " data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Influencer Script
                                            </button>
                                            <button class="btn collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Company Message
                                            </button>
                                            <button class="btn collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Links
                                            </button>
                                            <button class="btn collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                Branches
                                            </button>
                                        </div>
                                        <div class="card">
                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body">
                                                    {{$campaign->influencers_script}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="card-body">
                                                    {{$campaign->company_msg}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="card-body">
                                                    <a href="{{$campaign->visit_coverage}}" target="_blank" type="button" class="btn "> <i class="fas fa-link"></i> Visit Coverage </a>
                                                    <a href="{{$campaign->delivery_coverage}}" target="_blank" type="button" class="btn "> <i class="fas fa-link"></i> Delivery Coverage </a>
                                                    <a href="{{$campaign->visit_coverage}}" target="_blank" type="button" class="btn "> <i class="fas fa-link"></i> Confirmation </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="tab_content_countries">
                                                        <ul class="nav nav-tabs nav-fill branch_menu" style="padding: 0 !important;" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link branchCountry active" onClick="branchCountryFilter('allBranch', 0)"  data-toggle="tab" href="#allBranch" role="tab" data-branch-country-id="0" data-branch-country-name="allBranch" aria-controls="all" aria-selected="true"><i class="fas fa-asterisk"></i> ALL</a>
                                                            </li>
                                                            @foreach($countries as $country)
                                                                <li class="nav-item">
                                                                    <a class="nav-link branchCountry" data-toggle="tab" href="#{{$country->name}}" role="tab" onClick="branchCountryFilter('{{$country->name}}', '{{$country->id}} ')"  aria-selected="true">
                                                                        <img style="display: inline-block;margin-bottom: 2px;" src="https://hatscripts.github.io/circle-flags/flags/{{\Illuminate\Support\Str::lower($country->code)}}.svg" width="26" class="img-flag">
                                                                        {{$country->name}}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="tab-content" style="margin-top:10px;padding:10px 20px">
                                                            <div class="tab-pane active tab-pane-branch" id="allBranch" role="tabpanel">
                                                                <ul class="align-items-center" id="branchesData">
                                                                    @foreach($allBranches as $branch)
                                                                        <li class="d-flex align-items-center"> <i class="fas fa-map-marked-alt"></i> {{$branch->name}}</li>
                                                                    @endforeach
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
                    </div>
                </div>
                <div class="bottom-content">
                    @include('admin.dashboard.campaign.favouriteList_datatable')
                    @include('admin.dashboard.campaign.models.visit_details')
                    @include('admin.dashboard.campaign.models.delivered_details')
                    @include('admin.dashboard.campaign.models.generate_qr_secret')
                    @include('admin.dashboard.campaign.models.camp_status')
                    @include('admin.dashboard.campaign.models.complain')
                    @include('admin.dashboard.campaign.models.add_influencer')
                    @include('admin.dashboard.campaign.models.import_excel')
                    @include('admin.dashboard.campaign.models.coverage_modal')
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

    @include('admin.dashboard.layouts.includes.general.scripts.index')
    <script src="{{asset('js/campaign/show.js')}}"></script>
    @if(session()->has('successful_message'))
        <script>Swal.fire("Good job!", "{{session()->get('successful_message')}}", "success");</script>
    @elseif(session()->has('error_message'))
        <script>Swal.fire("Good job!", "{{session()->get('error_message')}}", "error");</script>
    @endif
    <script>

        editor = new $.fn.dataTable.Editor( {
            ajax: {
                url:"{{route('dashboard.campaign.edit.column')}}",
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success:function(d){
                    if(d.status='success'){
                        exampleTbl.ajax.reload()
                        Swal.fire("Updated!", "Updated Successfully!", "success");


                    }
                },
                error:function (d){
                   var error =d.responseJSON;
                   if(error.message){
                       Swal.fire("Attention!", `${error.message}`, "warning");
                   }


                }
            },
            table: "#exampleTbl",
            idSrc:  'id',

            fields: [
                {
                    name: "confirmation_date",
                    type: 'datetime',
                },
                {
                    name: "date",
                    type: 'datetime',

                },
                {
                    name: "folderId",
                    type: 'textarea',

                },
                {
                    name: "coverage_date",
                    type: 'datetime',
                },
                {
                    name: "comment_rate",
                    type: 'textarea',
                    attr:{
                        placeholder:'Enter Comment Rate'
                    }
                },
                {
                    name: "rate",
                    type: 'select',
                    options: [
                        {
                            label:"select",
                            value:null,
                        },
                        {
                            label:"*",
                            value:'1',
                        },
                        {
                            label:"*",
                            value:'1',
                        },
                        {
                            label:"**",
                            value:'2',
                        },
                        {
                            label:"***",
                            value:'3',
                        },
                        {
                            label:"****",
                            value:'4',
                        },
                        {
                            label:"*****",
                            value:'5',
                        },

                    ]
                },
                {
                  name: "coverage_status",
                  type: "datatable",
                  multiple:true,
                    options: [
                        {
                            label:"Done",
                            value:'done',
                        },
                        {
                            label:"Need Swip",
                            value:'need_swip',
                        },
                        {
                            label:"Need Mention",
                            value:'need_mention',
                        },
                        {
                            label:"Wrong Mention",
                            value:'wrong_mention',
                        },
                        {
                            label:"Need Brief",
                            value:'need_brief',
                        },
                        {
                            label:"Need Tiktok",
                            value:'need_tiktok',
                        },
                        {
                            label:"Need Snapchat",
                            value:'need_snapchat',
                        },
                    ]

                },
                {
                    name: "branches",
                    type: "select",
                    options: [
                        {
                          label:"select",
                          value:null,
                        },
                            @foreach($allBranches as $branch)
                        {
                            label: "{{$branch->name}}",
                            value:"{{$branch->id}}",
                        },
                            @endforeach
                    ]
                },
                {
                    name: "brief",
                    type: "select",
                    options: [

                        {
                            label:"select",
                            value:null,
                        },
                        {
                            label: "Send",
                            value:'1',
                        },
                        {
                            label: "Not Send",
                            value:'0',
                        },


                    ]
                }

            ],


        });


        editor.on( 'preSubmit', function ( e, o, action ) {

            if ( action !== 'remove' ) {
                var date = this.field( 'date' );
                var folderId = this.field( 'folderId' );
                var branches = this.field( 'branches' );
                var confirmation_date = this.field( 'confirmation_date' );
                if ( ! date.isMultiValue()  || ! confirmation_date.isMultiValue() ) {

                    if ( (!date.val() || !confirmation_date.val()) || ( confirmation_date.val()=='--' ||  date.val()=='--')  ) {
                        date.error( 'A Visit Date is required' );
                    }
                }

                if(this.inError()){
                    Swal.fire("Attention!", "Error!", "warning");
                    return false
                }
            }
        } );




        $('#exampleTbl').on( 'click', 'tbody td:not(:first-child)', function (e) {
            editor.bubble( this );
            // $('.DTE_Bubble_Background').appendTo('.table-responsive');
            // $('.DTE').appendTo('.table-responsive');
            // $('.dt-datetime').appendTo('.table-responsive');
            // $('.dt-datetime').appendTo('.table-responsive');
        } );





        $('#campaignType,#countryType,#influencersData').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#visitCheck,#qrCheck,#rateCheck').select2({
            placeholder: "Select",
            allowClear: true
        });

        let campaign_type = '{{($campaign->campaign_type == 2 || $campaign->campaign_type == 0) ? 0 : 1}}';
        let country_id = 0;
        let camp_id = "{{$campaign->id}}"
        let camp_sub_type = 0
        let visibleDateColumn = false



        let exampleTbl =$("#exampleTbl").DataTable({
            lengthChange: true,
            "processing": true,
            "serverSide": true,
            responsive: true,
            searching: true,
            dom: 'Blfrtip',
            "buttons": [
                'colvis',
            ],
            'columnDefs': [{ 'orderable': false, 'targets': 0 }],
            'aaSorting': [[1, 'asc']],
            "ajax": {
                url: "{{route('dashboard.campaigns.campaignFavouriteListDatatables')}}",
                data: function (d) {
                    d.country_val = country_id;
                    d.campaign_type_val = campaign_type;
                    d.camp_id = camp_id;
                    d.camp_sub_type = camp_sub_type;
                    d.qrCheck = $('#qrCheck').val();
                    d.rateCheck = $('#rateCheck').val();
                    d.visitCheck = $('#visitCheck').val();
                    d.qrcode_search_form_input = $('#qrcode_search_form_input').val();
                    d.brief = $('#brief').val();
                    d.custom = $('#custom').val();
                    d.coverage_status = $('#coverage_status').val();
                    TabsCounter();
                }
            },

         "columns": [

                {
                    "data": "id",
                    "sortable": false,
                    render: function (data, type) {
                        return '<input type="checkbox"  value="' + data + '" class="check-box1" >';
                    }
                },
                {"data": "ig_name"},


                {"data": "full_name"},
                {"data": "country",
                    render: function (data, type) {
                        return `<img class="img-flag" width="26" style="margin: auto;display: inline" src="https://hatscripts.github.io/circle-flags/flags/${data}.svg">`;
                    }
                },
                {"data": "visit_date"},
                {"data": "confirmation_date",
                    editField: [ 'confirmation_date','branches']
                },
                {"data": "branches"},
                {"data": "invetaion",

                render:function(data,type){
                    const invetaion=[];
                    if(!data)
                        invetaion.push( `<i class="fa-solid fa-xmark"></i>`)
                    else
                         invetaion.push( `<i class="fa fa-check" aria-hidden="true"></i>`)

                    return invetaion;
                }

                },
                {"data": "brief"},
                {"data": "followers"},
                {"data": "engagement"},
                {"data": "addedAt"},
                {"data": "sn_name"},

                {"data": "socials",className:'starRate',
                    render: function (data, type) {

                        const social_arr=[];
                        if(data.tiktok){
                            social_arr.push(`<a style="font-size:16px" target="_blank" href="https://www.tiktok.com/${data.tiktok}"><i style="color: #000;" class="fas fa-icons"></i></a>`)
                        }if(data.snap){
                            social_arr.push(`<a style="font-size:16px" target="_blank" href="https://story.snapchat.com/${data.snap}"><i style="color:#fffc00;" class="fab fa-snapchat"></i></a>`)
                        } if(data.twitter){
                            social_arr.push(`<a style="font-size:16px" target="_blank" href="https://twitter.com/${data.twitter}"><i style="color: rgb(29, 155, 240);" class="fab fa-twitter"></i></a>`)
                        } if(data.fb){
                            social_arr.push(`<a style="font-size:16px" target="_blank" href="https://www.facebook.com/${data.fb}"><i class="fab fa-facebook"></i></a>`)
                        }if(data.insta){
                            social_arr.push(`<a style="font-size:16px" target="_blank" href="https://www.facebook.com/${data.insta}"><i class="fab fa-instagram"></i></a>`)
                        }

                        return    social_arr;
                    }
                },
                {"data": "date",
                    editField: [ 'date','branches']},


                {
                    "data": "qrCodeStatus"
                },

                {
                    "data": "status",
                    render: function (data, type) {

                        return campaignInfluencerStatus(data);
                    }

                },

                {"data": "coverage_status"},
                {"data": "coverage_date"},

                {"data": "reason"},
                {"data": "lang"},
                {"data": "rate"},
                {"data": "rate",className:'starRate',
                    editField: [ 'rate','comment_rate'],
                 render: function (data, type) {
                    var star=[];

                    for (var i=1 ; i <= data ; i++)
                    {
                        star.push(`<span ><i class="fas fa-star" style="color:#d1cc30 !important;"></i></span>`)
                    }

                     // console.log(star);
                     return star
                    }
        },
                {"data": "complain",
                    render: function (data, type) {
                        let Details='';
                        if(data){
                            if(data['status'] ==0){
                                Details =  'Un-Resolvrd';
                            }else{
                                Details =  'Resolved';
                            }
                        }else{
                            return 'No Complain'
                        }

                        return Details
                    }
                },

                    @can('update campaigns') {
                    "data":"role",
                    "sortable": false,
                    render: function (data, type) {
                        let Details='';
                        if(campaign_type ==0){
                            Details =  ' <button  class="btn text-center details_moodal" data-toggle="modal" data-id="'+ data.influ_id +'" data-target="#visit_details"><i class="fas fa-bus"></i> Details</button>';
                        }else{
                            Details =  '<button  class="btn btn-info text-center  details_moodal" data-toggle="modal" data-target="#delivered_details"><i class="fas fa-map-marked-alt"></i> Details</button>';
                        }
                        return Details
                    }
                },

                    @endcan
                {
                    "data": "id",
                    render: function (data, type) {
                        let showbtn=``
                        if(!localStorage.getItem('TapType')=='all'){
                            showbtn=`<a href="javascript:void(0)" class="btn btn-danger mt-2 mb-2 uprow" data-id="${data}" id="del-${data}">
                                      </a>`;
                        }

                        return `<td>
                            <div class="d-flex" style="gap:5px;">
                                <a href="javascript:void(0)" title="Complain" class="btn mt-2 mb-2 openModalComplain" data-toggle="modal"  data-target="#camp_complain" data-id="${data}">
                                    <i class="fas fa-commenting"></i>
                                </a>
                                <a href="javascript:void(0)" title="Complain" class="btn mt-2 mb-2 delRow"  data-id="${data}" data-toggle="modal" >
                                    <i class="fas fa-trash"></i>
                                </a>`;


                        return `<td>
                            <div class="d-flex" style="gap:5px;">
                                @can('delete campaigns')
                                       <a href="javascript:void(0)" class="btn btn-danger mt-2 mb-2 delRow" data-id="${data}" id="del-${data}">
                                        <i class="far fa-trash-alt"></i>
                                     </a>
                                 @endcan
                                 @can('delete campaigns')
                                   <div class="btn-group">
                                           <button id="statusdone" data-id="${data}" style="border-radius:8px;border-radius: 8px;padding: 0.4rem 1rem;width: fit-content;" type="button" class="camp-status-visit-modal btn btn-success mr-2"  aria-haspopup="true" aria-expanded="false">
                                                    Status
                                           </button>
                                         <div class="dropdown-menu"  style="background: #888e9b">
                                               <a class="dropdown-item camp-status-visit-modal-for-oneinfluncer" href="#">Visit</a>
                                      <a class="dropdown-item camp-status-confirm-modal" href="#">Confirm</a>
                                       </div>
                                     </div>
                                    @endcan

                            ${showbtn}

                            </div>
                        </td>`;
                    }

                },


            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            fixedHeader: {
                header: true,
            },
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
            columnDefs: [{
                'orderable': false,
                'targets': 0
            }],
            language: {
                searchPlaceholder: 'Search',
                sSearch: '',
            }
        });
        $('#exampleTbl_length').append('<input type="text" id="custom" placeholder="Search"/>')

        // $('.btn_table').append('<input type="text" id="custom" placeholder="Search"/>')
        exampleTbl.buttons('.buttons-collection').nodes().css("display", "none");
        function campaignTypeSwitch(type){
            campaign_type = type;
            country_id = 0;
            camp_sub_type = 0;
            if( campaign_type == 0 ){
                $('.campaign-inner').attr('id', 'visit')
                visibleDateColumn = false;
                $("#attendees").show()
                $("#incorrectCamp").show()
                $("#campaign_date").html('[{{$campaign->visit_start_date}} / {{$campaign->visit_end_date}}]')

            }else{
                $('.campaign-inner').attr('id', 'delivery')
                visibleDateColumn = true;
                $("#attendees").hide()
                $("#incorrectCamp").hide()
                $("#campaign_date").html('[{{$campaign->deliver_start_date}} / {{$campaign->deliver_end_date}}]')
            }

            exampleTbl.ajax.reload()
        }

        function getHeaderNeed(){

        }

        function TabsCounter(){
            $.ajax({
                url:"{{route('dashboard.campaigns.influencers.status.counter')}}",
                type:'get',
                data:{'_token':'{{ csrf_token()}}', 'camp_id':'{{ $campaign->id }}'},
                success:function(d){
                    $('#count_all').html(d.count_all);
                    $('#count_confirmation').html(d.count_confirmation);
                    $('#count_visit').html(d.count_visit);
                    $('#count_not_visit').html(d.count_not_visit);
                    $('#count_cancel').html(d.count_cancel);
                    $('#count_waiting').html(d.count_waiting);
                    $('#count_incorrect').html(d.count_incorrect);
                    $('#count_coverage').html(d.count_coverage);
                    $('#count_complaint').html(d.count_complaint);
                }
            })
        }
         function campaignSubTypeSwitch(type){

            camp_sub_type = type
           if(camp_sub_type==0){
               camp_sub_id="all-camp"
           }else if(camp_sub_type==1){
               localStorage.setItem('TapType','confirmed');

               camp_sub_id="confirmed-camp"
            }else if(camp_sub_type==2){

               localStorage.setItem('TapType','visit');
               camp_sub_id="visit-camp"
            }else if(camp_sub_type==3){

               camp_sub_id="not-visit-camp"

            }else if(camp_sub_type==4){
                // $('.deletdata').remove();

                camp_sub_id="cancel-camp"
            }else if(camp_sub_type==5){

            camp_sub_id="wating-camp"

        }else if(camp_sub_type==6){

            camp_sub_id="incorrect-camp"
        }else if(camp_sub_type==7){

          camp_sub_id="coverage-camp"
      }

        console.log('camp_sub_id', camp_sub_id, 'camp_sub_type', camp_sub_type);
        if(camp_sub_type == 1){

            localStorage.setItem('TapType','confirmed');

        }
        $(".camp_sub").attr('id', camp_sub_id)
        exampleTbl.ajax.reload()
        }

        function campaignSubTypeSwitch(type){
            camp_sub_type = type
            if(camp_sub_type==0){
                for($i = 1;$i<=24;$i++){exampleTbl.column($i).visible(true);}
                console.log('The TapType is All');
                camp_sub_id="all-camp"
                localStorage.setItem("TapType", 'all');
                $('.filterSearch').show();
                $('.btn_table').contents(':not(#custom,.check-modal,#dele-All,#importExcelList)').remove();
                let check_modal= document.querySelectorAll('.btn_table #importExcelList .openImportModal');
                check_modal .forEach((item)=>{
                    item.style='display:block';
                })
                $('.btn_table').prepend(`
                <div class="btn-group">
                    <button  type="button" style="border-radius:8px;border-radius: 8px;padding: 0.4rem 1rem;width: fit-content;" class="btn btn-success dropdown-toggle mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Status
                        </button>
                        <div class="dropdown-menu"  style="background: #888e9b">
                            <a class="dropdown-item camp-status-visit-modal" href="#">Visit</a>
                            <a class="dropdown-item camp-status-confirm-modal" href="#">Confirm</a>
                            </div>
                            </div>
                            `);

                        }else if(camp_sub_type==1){
                            for($i = 1;$i<=24;$i++){exampleTbl.column($i).visible(true);}
                            for($i = 11;$i<=24;$i++){exampleTbl.column($i).visible(false);}
                            exampleTbl.column(4).visible(false)
                            camp_sub_id="confirmed-camp"
                            console.log('The TapType is Confirmed');
                            localStorage.setItem("TapType", 'confirmed');
                            $('.btn_table').contents(':not(#custom,.check-modal,#dele-All,#importExcelList)').remove();
                $('.filterSearch').hide();
                $('.btn_table #importExcelList').show()
                let check_modal= document.querySelectorAll('.btn_table #importExcelList .openImportModal');
                check_modal .forEach((item)=>{
                    let atrr = item.getAttribute('data-modal')
                    if(atrr=='CheckList'){
                        item.style='display:none';
                    }else{
                        item.style='display:block';
                    }
                })
                $('.btn_table').prepend(`
                <button type="button" style="border-radius:8px;" class="btn mr-2 float-right  camp-status-visit-modal">
                    <i class="fas fa-qrcode"></i> Visit
                    </button>
                    `);
                }else if(camp_sub_type==2){
                    for($i = 1;$i<=24;$i++){exampleTbl.column($i).visible(true);}

                    for($i = 9;$i<=16;$i++){exampleTbl.column($i).visible(false);}
                    camp_sub_id="visit-camp"
                    localStorage.setItem("TapType", 'visit');
                    console.log('The TapType is Visit');
                    exampleTbl.column(5).visible(false);
                    exampleTbl.column(7).visible(false);
                    exampleTbl.column(19).visible(false);
                    $('.filterSearch').hide();
                    $('.btn_table #importExcelList').show()
                    $('.btn_table').contents(':not(#custom,.check-modal,#dele-All,#importExcelList)').remove();
                    let check_modal= document.querySelectorAll('.btn_table #importExcelList .openImportModal');
                    check_modal .forEach((item)=>{
                        let atrr = item.getAttribute('data-modal')
                        if(atrr=='Confirmation'){
                            item.style='display:none';
                        }else{
                            item.style='display:block';
                        }
                    })
                    $('.btn_table').prepend(`
                    <button type="button" style="border-radius:8px;" class="btn mr-2 float-right  camp-status-visit-modal">
                        <i class="fas fa-qrcode"></i> Coverage
                        </button>
                        `);

                    }else if(camp_sub_type==3){
                        for($i = 1;$i<=24;$i++){exampleTbl.column($i).visible(true);}
                        for($i = 4;$i<=8;$i++){exampleTbl.column($i).visible(false);}
                        for($i = 12;$i<=24;$i++){exampleTbl.column($i).visible(false);}
                        camp_sub_id="not-visit-camp"
                        localStorage.setItem("TapType", 'not-visit');
                        console.log('The TapType is Not Visit');
                        $('.filterSearch').hide();
                        $('.btn_table').contents(':not(#custom,.check-modal,#dele-All,#importExcelList)').remove();
                        $('.btn_table #importExcelList').hide()
                        $('.btn_table').prepend(`
                        <button type="button" style="border-radius:8px;" class="btn mr-2 float-right  camp-status-confirm-modal">
                            <i class="fas fa-qrcode"></i> Confirm
                            </button>
                            <button type="button" style="border-radius:8px;" class="btn mr-2 float-right" id="updatebulkconfirm">
                  <i class="fas fa-qrcode"></i> updatemultiinfl
                  </button>

                  `)


                }else if(camp_sub_type==4){
                    for($i = 1;$i<=24;$i++){exampleTbl.column($i).visible(true);}
                        for($i = 4;$i<=8;$i++){exampleTbl.column($i).visible(false);}
                        for($i = 12;$i<=24;$i++){exampleTbl.column($i).visible(false);}
                    camp_sub_id="cancel-camp"
                    localStorage.setItem("TapType", 'cancel');


                    $('.filterSearch').hide();
                    $('.btn_table').contents(':not(#custom,.check-modal,#dele-All)').remove();
                    $('.btn_table').prepend(`
                    <button type="button" style="border-radius:8px;" class="btn mr-2 float-right  camp-status-confirm-modal">
                        <i class="fas fa-qrcode"></i> Confirm
                        </button>
                        <button type="button" style="border-radius:8px;" class="btn mr-2 float-right" id="updatebulkconfirm">
                            <i class="fas fa-qrcode"></i> updatemultiinfl
                            </button>
                            `)
                        }else if(camp_sub_type==5){
                            for($i = 1;$i<=24;$i++){exampleTbl.column($i).visible(true);}
                            exampleTbl.column(4).visible(false);
                            exampleTbl.column(6).visible(false);
                            exampleTbl.column(7).visible(false);
                            for($i = 11;$i<=24;$i++){exampleTbl.column($i).visible(false);}
                            camp_sub_id="wating-camp"
                            $('.filterSearch').hide();
                            localStorage.setItem("TapType", 'wating');
                            console.log('The TapType is Wating');
               $('.btn_table').contents(':not(#custom,.check-modal,#dele-All)').remove();
           }else if(camp_sub_type==6){
               camp_sub_id="incorrect-camp"
               $('.filterSearch').hide();
               localStorage.setItem("TapType", 'incorrect');
               $('.btn_table').contents(':not(#custom,.check-modal,#dele-All)').remove();
           }




            // console.log('camp_sub_id', camp_sub_id, 'camp_sub_type', camp_sub_type);
            if(camp_sub_type == 1){

            }
            $(".camp_sub").attr('id', camp_sub_id)
            exampleTbl.ajax.reload()
        }

        function appendSectionId(event){
            country_id =  $(event.currentTarget).attr('data-countryId');
            let sectionId = $(event.currentTarget).attr('data-sectionId')
            $(".country-visit-active").attr('id', sectionId)
            exampleTbl.ajax.reload();
        }

        $('#exampleTbl tbody').on( 'click', 'button', function (event) {
            event.preventDefault()
            let data = exampleTbl.row( $(this).parents('tr') ).data();
            $(".inflencer_username").html('@'+data.role.user_name)
            $('.imagePic').attr("src",data.role.image);

            $(".inflencer_name").html(data.name)
            $(".camp_influ_id").val(data.id)
            if( campaign_type == 0){
                $("#qrcode").attr('download', data.role.qr_code )
                $("#qrcode img").attr('src', data.role.qr_link )
                $("#qrcode").attr('href', data.role.qr_link )
                $("#code").html(data.role.code)
                $("#validTimes").html(data.role.qrcode_valid_times)
                $("#validTime_input").val(data.role.qrcode_valid_times)
                $("#noOfUses").html(data.role.no_of_uses)
                if( data.role.no_of_uses < data.role.qrcode_valid_times){
                    $("#valid").html('').append(`<span class="badge badge-pill badge-success"><i class="fa fa-fw fa-check-circle fa-sm"></i> Valid </span>`)
                }else if( data.role.no_of_uses >= data.role.qrcode_valid_times ){
                    $("#valid").html('').append(`<span class="badge badge-pill badge-danger"><i class="fas fa-times-circle"></i> Not Valid </span>`)
                }
                if(data.role.test_code != null || data.role.test_qr_code != null ){
                    $("#test_qrcode").attr('download', data.role.test_qr_code )
                    $("#test_qrcode img").attr('src', data.role.test_qr_link )
                    $("#test_qrcode").attr('href', data.role.test_qr_link )
                    $("#test_code").html(data.role.test_code)
                    $("#test_code_card").parent().show()
                }else if(data.role.test_code == null && data.role.test_qr_code == null ){
                    $("#test_code_card").parent().hide()
                }
            }else{
                $("#address").val(data.role.address)
                $("#location").val(data.role.location)
                $("#date").val(data.role.date)
                $("#time").val(data.role.time)
                $("#note").val(data.role.notes)
                $("#influencer_id").val(data.role.influencer_id)
                $("#phoneDiv").html('')
                if( data.role.phone ){
                    $.each( data.role.phone , function( key, value ) {
                        $("#phoneDiv").append(`
                         <input type="number" name="phone[]" class="form-control mb-3 phone" placeholder="Phone" value="${value}" minlength="5" maxlength="15">
                    `)
                    })
                }else{
                    $("#phoneDiv").append(`
                         <input type="number" name="phone[]" class="form-control mb-3 phone" placeholder="Phone" value="" minlength="5" maxlength="15">
                    `)
                }
            }
        } );
        //Switch
        $('#exampleTbl tbody').on( 'change', '.switch', function (event) {
            let data = exampleTbl.row( $(this).parents('tr') ).data();
            $.ajax({
                type: 'POST',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: '{{route('dashboard.campaigns.take_camp')}}',
                data: {take_camp:data.take_camp,camp_influ:data.id},
                dataType: 'json',
                success: function (data) {
                    if(data.status){
                        $('#delivered_details').modal('hide')
                        Swal.fire("Updated!", "Data Updated Successfully!", "success");

                        exampleTbl.ajax.reload();
                    }
                },
                error: function (data) {
                    // console.log(data);
                }
            });
        })
        //Deliver Details
        $('#saveDeliverDetail').off().on('click',function (event) {
            event.preventDefault()
            $.ajax({
                type: 'POST',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: '{{route('dashboard.campaigns.deliverDetails')}}',
                data: $("#deliverDetail_form").serialize(),
                dataType: 'json',
                success: function (data) {
                    if(data.status){
                        $("input").removeClass('parsley-error')
                        $(".parsley-errors-list li").html('')
                        $('#delivered_details').modal('hide')
                        Swal.fire("Updated!", "Deliver Detailes Updated Successfully!", "success");
                        exampleTbl.ajax.reload();
                    }
                },
                error: function (data) {
                    $.each(data.responseJSON.errors , function( key, value ) {
                        if(key.includes("phone") ) {
                            key = 'phone'
                            $(`.${key}`).addClass('parsley-error')
                        }
                        $(`.${key}-error`).html(value)
                        $(`#${key}`).addClass('parsley-error')
                    })
                }
            });
        })

        //Qrcode Valid Times
        function editQrCodeTime(e){
            $("#editvalidTime_form").toggle('show');
        }

        function SaveValidTime(e){
            $.ajax({
                type: "POST",
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('dashboard.campaigns.noOfUses')}}",
                dataType: 'json',
                data: $("#editvalidTime_form").serialize(),
                success: function(res){
                    $("#visit_details").modal('hide');
                    Swal.fire("Updated!", "No of Uses Updated Successfully!", "success");
                    exampleTbl.ajax.reload();
                    $("#validTime_input").removeClass('parsley-error')
                    $(".validTime_input_error").html('')
                    $("#editvalidTime_form").css('display', 'none');
                },
                error: function (error) {
                    $("#validTime_input").addClass('parsley-error')
                    $(".validTime_input_error").html(error.responseJSON.errors.validTime_input[0])
                }
            });
        }

        //Delete Camp
        $("#deleteCamp").on('click', function (event){
            event.preventDefault();
            Swal.fireDel("{{$campaign->id}}", "{{route('dashboard.campaigns.index')}}")
        })

        //branches Filter
        function branchCountryFilter(name, id){
            $('.tab-pane-branch').attr('id', name)
            $.ajax({
                type: "GET",
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('dashboard.campaigns.countryBranches')}}",
                dataType: 'json',
                data: {'country_id' : id, 'camp_id':"{{$campaign->id}}"},
                success: function(res){
                    $("#branchesData").html('')
                    $.each(res.data , function( key, value ) {
                        $("#branchesData").append(`
                        <li style="margin: 15px;"> <i class="fas fa-map-marked-alt"></i> ${value.name}</li>
                       `)
                    })
                },
                error: function (error) {
                    // console.log(error)
                }

            });
        }
        window.onload = function() {
            const dialogBtns = document.querySelectorAll(".dialog_btn");
            let dialogs = document.querySelectorAll(".dialog_content");
            dialogBtns.forEach((item,i)=>{
                item.addEventListener('click',()=>{
                    let dialog = item.parentElement.parentElement.querySelector('.dialog_content');
                    dialog.classList.toggle("active__new");
                    // console.log( item.parentElement.parentElement)
                    // item.parentElement
                    // dialogs[i].classList.toggle("active__new");
                    // console.log(dialogs)
                })
            })
        };
        $('#visitSearch').on('click',function (){
            exampleTbl.ajax.reload()

        })
        let mobal_btn = document.querySelectorAll(".openImportModal");
        let modal_box = document.querySelector("#import_excel");
        mobal_btn.forEach((item)=>{
            item.addEventListener('click',(e)=>{
                let atrr = item.getAttribute('data-modal')
                $(modal_box).modal('show');
                modal_box.querySelector('.modal-body').setAttribute('data-modal',atrr)
                mobalData(atrr);
            })
        })

        function mobalData(type){
            let mobal_form = modal_box.querySelector('.modal-body form');
            let mobal_footer = modal_box.querySelector('.modal-footer a');
            let action = ""
            switch (type) {
                case 'Confirmation':
                    action = "/dashboard/import/Confirmation"
                    mobal_form.setAttribute('action',action)
                    mobal_footer.setAttribute('href',"{{ asset('assets/import_files/confirmation.xlsx')}}")
                    mobal_footer.setAttribute('download',"/confirmation.xlsx")
                    break;
                case 'CheckList':
                    action = "/dashboard/import/CheckList"
                    mobal_form.setAttribute('action',action)
                    mobal_footer.setAttribute('href',"{{ asset('assets/import_files/checkIn.xlsx')}}")
                    mobal_footer.setAttribute('download',"/checkIn.xlsx")
                    break;




            }
        }

        $('#coverage_camp_modal').on('click',function (){
            $('#coverage_camp').modal('show')

        })
        $(document).on('input', '#custom', function() {
            exampleTbl.ajax.reload();
        })
    </script>
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
                    // console.log(curCol.style.width)
                    // console.log(tableWidth)
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
        <script>
            $('#visit_details').appendTo('.table-responsive');
            $('#camp_complain').appendTo('.table-responsive');
            // $('.DTE').appendTo('.table-responsive');
            // $('.DTE_Bubble_Background').appendTo('.table-responsive');


    </script>

    <script>
        $(window).on('load', function(){
            $('.modal.fade').appendTo('body');
        })
    $(".full-screen-helper .zoom-button").click(function () {
        location.reload(true);
    });
        $(document).on('click','.openModalCoverage',function(){
            $('#complain_text').val('');
            $('#get_influ_id').val($(this).attr('data-id'))

            var influ_id = $('#get_influ_id').val();
            var camp_id = "{{$campaign->id}}";
            $.ajax({
                url:'{{url("dashboard/influe/")}}',
                type:'post',
                data:{
                    '_token': '{{ csrf_token() }}' ,'influencer_id':influ_id, 'campaign_id':camp_id
                },success:function(res){
                    // console.log(res);
                }
            })
            //editStatus = false
            //$('#complain_text').val('');
            //$('#get_influ_id').val($(this).attr('data-id'))
            //if(localStorage.getItem('TapType') == "confirmed"){
            //    ('#camp_status .modal-body').append(
            //        `<form style="align-items :center ; gap :20px" id="camp_status">
            //            <div class="row mb-4">
            //                <div id="dataAppend">
            //                    <div class="col-sm-12 col-md-12" >
            //                        <label for="status_coverage_on" style=" margin-right: 151px; "> <input type="radio" id="status_on" name="change_coverage_stats" value="1">
            //                            &nbsp;Confirm</label><br>
            //                        &nbsp;<label for="status_coverage_off"><input type="radio" id="status_off" name="change_coverage_stats" value="2">
            //                            Pending</label><br>
            //                    </div>
            //                </div>
            //            </div>
            //        </form>`);
            //}
            //var influ_id = $('#get_influ_id').val();
            //var camp_id = "{{$campaign->id}}";

        })

    </script>

    <!-- <script>
        $(window).on('load', function(){
            $('.modal.fade').appendTo('body');
        })
    </script> -->



@endsection

