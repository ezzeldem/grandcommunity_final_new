<!-- Groups -->
<div class="col-xl-12 col-sm-12">
    <div class="card mg-b-20">
        <div class="card-body">
            <div class="pl-0 scroll">
                <div style="background: transparent;padding: 9px;text-align: center;">
                    <h5>{{$brand->name}} Groups</h5>
                </div>
                <div class="main-profile-overview">
                    <div class="row row-sm">
                        <div class="col-xl-12">
                            <div class="head-button mb-2">
                                @can('create group lists')
                                    <button class="btn hvr-sweep-to-right" title="Create Group"
                                            id="my_create"> Add Group
                                    </button>
                                @endcan
                                @can('delete group lists')
                                    <button class="btn hvr-sweep-to-right" title="Delete Group"
                                            id="btn_delete_all_groups"> Delete Group
                                    </button>
                                @endcan
{{--                                @can('update group lists')--}}
{{--                                    <button class="btn hvr-sweep-to-right" title="Edit Group"--}}
{{--                                            id="edit_group_name">Edit Group--}}
{{--                                    </button>--}}
{{--                                @endcan--}}
                                <button class="btn hvr-sweep-to-right" title="merge Groups" id="merge_group"
                                        data-toggle="modal"> Merge Group
                                </button>
                            </div>
                            <div class="main-profile-social-list mb-2">
{{--                                <form id="brand_groups_form">--}}
                                    <div style="display:flex;align-items: flex-start;justify-content: flex-start;">
                                        <input type="search" id="search_fav_table_list" placeholder="Search..">
                                    </div>
{{--                                </form>--}}
                                <div class="append" id="favTableAllFavsLine"></div>
                                <div class="parent-head "
                                     style="text-align: start;font-size: 14px;width: 100%;display: flex;justify-content: space-between;align-items: flex-start;flex-direction: row;gap: 15px;margin: 0;margin-bottom: 2px;">
                                    <span class=""><input name="select_all" id="fav_brand_groups_select_all" type="checkbox"/></span>
                                    <span class="">Name</span>
                                    <span class="">Color</span>
                                    <span class="">Country</span>
                                    <span class="">Brand</span>
                                    <span class="">Created At</span>
                                    <span class="">Count</span>
                                    <span class="">Options</span>
                                </div>
                                <!--Group div Loops -->
                                <div class="append " id="fav_brand_groups"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end groups -->


{{-- Tables    --}}
<div class="col-xl-12 col-sm-12">
    <div class="card">
        <div class="card-body">

            <div class="tab-content border-left border-bottom border-right border-top-0 p-4"
                 style="border: none !important;">
                <div class="tab-pane active" id="home">
                    <div class="row row-sm">
                        <div class="col-xl-12">
                            <div class="card mg-b-20">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between"
                                         style="background: transparent;padding: 9px;text-align: center">
                                        <h4 class="card-title mg-b-0" id="influe_group_title">ALL Favorite List</h4>
                                    </div>
                                    <div
                                        class="btn_group d-flex justify-content-start align-items-start flex-wrap flex-row"
                                        style="gap:8px">
                                        <button class="btn btn-dark hvr-sweep-to-right" title="Restore Influencer"
                                                data-toggle="modal" id="restore_influe" style="display: none"><i
                                                class="fas fa-trash-restore"></i></button>
                                        @can('create group lists')
                                            <button class="btn notBrand hvr-sweep-to-right" id="copy_influ">Copy
                                                influencers
                                            </button>
                                            <button class="btn hvr-sweep-to-right" id="import_excel"><i
                                                    class="fa fa-file"></i> Import
                                            </button>
                                            <button class="btn hvr-sweep-to-right" style="display: none;color: white;"
                                                    id="move_influ">Move influencers
                                            </button>
                                            <!-- <button class="btn hvr-sweep-to-right " id="export_wish_list">Export List</button> -->
                                            <a href="javascript:void(0)" class="btn hvr-sweep-to-right mt-3  export"
                                               id="exportWishListExcel" onclick="exportWishListExcel(event)">Export
                                                List</a>

                                            <!-- <button class="btn hvr-sweep-to-right"  id="add_to_campaign">Add To Campaign</button> -->
                                        @endcan
                                        {{--  <button class="btn hvr-sweep-to-right" style="" id="edit_add_datee">Edit date</button>--}}
                                        @can('delete group lists')
                                            <button class="btn hvr-sweep-to-right" id="delete_influe"><i
                                                    class="fas fa-trash"></i>Remove from favorite list
                                            </button>
                                            <button class="btn hvr-sweep-to-right " id="delete_influ_from_group">Move To
                                                Disliked
                                            </button>
                                            <button class="btn hvr-sweep-to-right " id="del_infl_from_group"
                                                    data-group="0" style="display: none;">Delete From Group
                                            </button>


                                        @endcan
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-start align-items-start" style="gap:8px">
                                        <input type="hidden" id="groupId">
                                        <input type="hidden" id="brand_id" value="{{$brand->id}}">
                                        <input type="hidden" id="country_taps">
                                        <input type="hidden" id="my_country"
                                               value="{{$brand->country_id ? implode(',',$brand->country_id) : ''}}">
                                        <input type="hidden" id="my_countrys"
                                               value="{{$brand->country_id ? implode(',',$brand->country_id) : ''}}">
                                    </div>
                                    <section class="filter-form">
                                        <div class="row filters" style="align-items:end">
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                                <input name="custom" id="custom" class="form-control"
                                                       placeholder="search ..">
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                                {!! Form::select('wish_country_search',getBrandCountries($brand,true),null,['class' =>'country_id_wish_search select2','data-show-subtext'=>'true','style'=>'width: 100%;background: #1a233a;color: #bcd0f7;border-color: #bcd0f761;border-radius: 2px;padding: 4px;outline: none;',
                                                  'data-live-search'=>'true','id' => 'country_id_wish_search','placeholder'=>'Select Country'])!!}
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                                <select class="form-control select2" id="visited_campaign_search">
                                                    <option selected value="">Visited Campaigns</option>
                                                    <option value="1">yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                                <button type="button" class="btn btn_search ml-1 hvr-sweep-to-right"
                                                        id="go_search_wish_brands">
                                                    <i class="fab fa-searchengin mr-1"></i>Search
                                                </button>
                                                <button type="button" class="btn btn_search ml-1 hvr-sweep-to-right"
                                                        id="go_reset_wish_brands">
                                                    <i class="fab fa-searchengin mr-1"></i>Reset
                                                </button>
                                            </div>
                                        </div>
                                    </section>

                                    <div class="table-responsive">
                                        <!-- <div class="zoom-container show_brands">
                                            <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                        </div> -->

                                        <table id="influe_group_list" class="table table-loader custom-table">
                                            <thead>
                                            <tr>
                                                <th class="border-bottom-0"><input type="checkbox" name="select_all"
                                                                                   id="select_all_influe"></th>
                                                <th class="border-bottom-0">Name</th>
                                                <th class="border-bottom-0">Username</th>
                                                <th class="border-bottom-0">Created at</th>
                                                <th class="border-bottom-0">Country</th>
                                                <th class="border-bottom-0">Social</th>
                                                <th class="border-bottom-0">groups</th>
                                                <th class="border-bottom-0">Visited Camapaigns</th>
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
                </div>
                {{--  End Tab One --}}
            </div>
        </div>
    </div>
</div>
{{-- End Tables--}}


<div class="modal fade" id="import_excel_modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{  url('dashboard/groupList/import') }}" method="POST" enctype="multipart/form-data"
                  id="submit_import_form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import WishList</h5>
                    <button type="button" class="close close_import_excel_modal" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" name="file" id="import_influe_to_group" accept=".xls,.xlsx,.xlsm,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    <input type="hidden" name="groupId" id="importgroupId">
                    <input type="hidden" name="brand_id" id="importBrandId" value="{{$brand->id}}">
                </div>
            </form>
            <div class="modal-footer" style="justify-content: space-between !important;">

                <a download="/wishlist.xlsx" type="button" class="btn btn-dark"
                   href="{{ asset('assets/import_files/wishlist.xlsx')}}"> <i class="bi bi-download"></i>
                    <i class="fas fa-download"></i> Sample</a>
                <div class="dev">
                    <button type="button" class="btn close_import_excel_modal Delete hvr-sweep-to-right"
                            data-dismiss="modal">Close
                    </button>
                    <button type="button" id="import_excel_btn" class="btn Active hvr-sweep-to-right">Import</button>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.dashboard.brands.models.copy_influencer_to_group')
@include('admin.dashboard.brands.models.unfavorite_influencers')
@include('admin.dashboard.brands.models.dislike_influencers')
@include('admin.dashboard.brands.models.add_group')
@include('admin.dashboard.brands.models.delete_group_list_modal')
@include('admin.dashboard.brands.models.merge_group_list')


<style>
    .active_now {
        background: var(--main-bg-color);
        color: white !important;
    }

    .parent-head {
        background: var(--table-header-bg);
        padding: 11px;
        border-radius: 2px;
        font-weight: bold;
        margin-bottom: 11px;
        text-align: center;
        color: white;
    }

    .group-details {
        padding: 10px;
        /* border-bottom: 1px solid #1a243a; */
    }

    .group-details-restore {
        padding: 10px;
        /* border-bottom: 1px solid #1a243a; */
    }

    .group-noFound {
        padding: 10px;
        border-bottom: 1px solid #ced4db;
    }

    .group-details .row span {
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .group-noFound .row span {
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .group-details-restore .row span {
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .main-profile-overview {
        /* padding:15px; */
        margin-bottom: 10px;
        border-radius: 4px;
        /* background: var(--main-bg-color);
        box-shadow: 0 10px 27px rgb(0 0 0 / 30%), 0 0px 2px rgb(0 0 0 / 22%); */
        /*overflow: scroll;*/
        height: 500px;
    }

    .new-active {
        background: #191a1b;
        /*color: #fff;*/
    }

    .head-button {
        display: flex;
        align-items: flex-start;
        justify-content: flex-start;
        margin-bottom: -26px;
        flex-wrap: wrap;
        gap: 6px;
    }

    .append .group-details {
        cursor: pointer;
        color: white;
    }

    append .group-details-restore {
        cursor: pointer;
        color: white;
    }

    .main-profile-social-list {
        overflow-x: hidden;
        height: 350px;
    }

    .btn_group {
        margin-top: 5px;
        text-align: center;
    }

    .profile {
        width: 100%;
        justify-content: flex-start;
        background: var(--body-bg-color);
        padding: 10px;
        border-radius: 20px;
    }

    .parent_nav .active {
        background: VAR(--main-bg-color);
        color: white !important;
    }

    .tapsli {
        padding: 8px 14px;
        border-radius: 23px;
        border: 3px solid #333;
        color: #fff !important;
        padding-left: 8px;
        padding-right: 12px;
        margin-left: 2px;
    }

    .tapsli a {
        color: white;
        background: transparent !important;
    }

    .main-profile-social-list::-webkit-scrollbar {
        width: 2px;
    }

    .main-profile-social-list::-webkit-scrollbar-track {
        background: #131313;
    }

    .main-profile-social-list::-webkit-scrollbar-thumb {
        background: #9b7029;
    }

    .main-profile-social-list::-webkit-scrollbar-thumb:hover {
        background: #9b7029;
    }

    .dataTables_filter {
        display: none;
    }

    #custom {
        border-radius: 2px;
        font-size: .825rem;
        background: #1A233A;
        color: #bcd0f7;
        border: none;
        padding: 5px;
        float: right;
    }

    .styled-scrollbars {
        /* Foreground, Background */
        scrollbar-color: #999 #333;
    }

    .styled-scrollbars::-webkit-scrollbar {
        width: 5px; /* Mostly for vertical scrollbars */
        height: 10px; /* Mostly for horizontal scrollbars */
    }

    .styled-scrollbars::-webkit-scrollbar-thumb { /* Foreground */
        background: #a5dc86;
    }

    .styled-scrollbars::-webkit-scrollbar-track { /* Background */
        background: #333;
    }
</style>
