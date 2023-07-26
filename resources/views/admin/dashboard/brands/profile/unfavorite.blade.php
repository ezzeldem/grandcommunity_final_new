    <!-- Groups -->
{{--    <div class="col-xl-12 col-sm-12">--}}
{{--        <div class="card mg-b-20">--}}
{{--            <div class="card-body">--}}
{{--                <div class="pl-0 scroll">--}}
{{--                    <div style="background: transparent;padding: 9px;text-align: center;">--}}
{{--                        <h5>{{$brand->name}} Groups</h5>--}}
{{--                    </div>--}}
{{--                    <div class="main-profile-overview">--}}
{{--                        --}}
{{--                        <!-- End Tabs -->--}}
{{--                            --}}
{{--                                <div class="row row-sm">--}}
{{--                                    <div class="col-xl-12">--}}
{{--                                        <div class="head-button mb-2">--}}
{{--                                            <button class="btn hvr-sweep-to-right" title="Restore Group" data-toggle="modal"  id="restore">Restore</button>--}}
{{--                                        </div>--}}
{{--                                        <div class="main-profile-social-list mb-2">--}}
{{--                                            <form>--}}
{{--                                                <div style="display:flex;align-items: self-end;justify-content: flex-end;">--}}
{{--                                                    <input  type="search" id="search_unfav_table_list" placeholder="Search..">--}}
{{--                                                </div>--}}
{{--                                            </form>--}}
{{--											<div class="parent-head" style="text-align: start;font-size: 14px;width: 100%;display: flex;justify-content: space-between;align-items: flex-start;flex-direction: row;gap: 15px;margin: 0;margin-bottom: 2px;">--}}
{{--														<span class=""><input name="select_all" id="select_all" type="checkbox" /></span>--}}
{{--														<span class="">Name</span>--}}
{{--														<span class="">Color</span>--}}
{{--														<span class="">Country</span>--}}
{{--														<span class="">Brand</span>--}}
{{--														<span class="">Created At</span>--}}
{{--														<span class="">Count</span>--}}
{{--											</div>--}}
{{--                                            <!--Group div Loops -->--}}
{{--                                            <div class="append" id="unfav_brand_groups">--}}
{{--											</div>--}}
{{--                                            <div class="ajax-load text-center" style="display: none">--}}
{{--                                                <p><img src="{{asset('assets/img/1496.gif')}}"></p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                           --}}
{{--                    </div><!-- main-profile-overview -->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- end groups -->


    {{-- Tables    --}}
    <div class="col-xl-12 col-sm-12">
        <div class="card">
            <div class="card-body" >

                <div class="tab-content border-left border-bottom border-right border-top-0 p-4"  style="border: none !important;">
                    <div class="tab-pane active" id="home">
                        <div class="row row-sm">
                            <div class="col-xl-12">
                                <div class="card mg-b-20">
                                   <div class="card-body">

								   <section class="filter-form">
												<div class="row filters" style="align-items:end">
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                                        <button type="button" class="btn btn_search ml-1 hvr-sweep-to-right" id="add_unfavourites_to_favourites" >
                                                            <i class="fa fa-heart mr-1"></i>Add To Favorite
                                                        </button>
                                                    </div>
													<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2" >
														{!! Form::select('country_id_unfavorite_search',getBrandCountries($brand,true),null,['class' =>'country_id_unfavorite_search select2','data-show-subtext'=>'true','style'=>'width: 100%;background: #1a233a;color: #bcd0f7;border-color: #bcd0f761;border-radius: 2px;padding: 4px;outline: none;',
													      'data-live-search'=>'true','id' => 'country_id_unfavorite_search','placeholder'=>'Select Country'])!!}
													</div>

													<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
														<button type="button" class="btn btn_search ml-1 hvr-sweep-to-right" id="go_search_unfavorite_brands" >
															<i class="fab fa-searchengin mr-1"></i>Search
														</button>
														<button type="button" class="btn btn_search ml-1 hvr-sweep-to-right" id="go_reset_unfavorite_brands" >
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
                                            <div class="d-flex justify-content-start align-items-start" style="gap:8px">
                                                <input type="hidden" id="groupId">
                                                <input type="hidden" id="brand_id" value="{{$brand->id}}">
                                                <input type="hidden" id="country_taps">
                                                <input type="hidden" id="my_country" value="{{$brand->country_id ? implode(',',$brand->country_id) : ''}}">
                                                <input type="hidden" id="my_countrys" value="{{$brand->country_id ? implode(',',$brand->country_id) : ''}}">
                                            </div>
                                            <table  id="unfavorite_influe_group_list" class="table table-loader custom-table">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0"><input type="checkbox" name="select_all" id="select_all_unfavinflue"></th>
                                                        <th class="border-bottom-0">Name</th>
                                                        <th class="border-bottom-0">Username</th>
                                                        <th class="border-bottom-0">Created at</th>
                                                        <th class="border-bottom-0">Country</th>
                                                        <th class="border-bottom-0">Social</th>
{{--                                                        <th class="border-bottom-0">groups</th>--}}
{{--                                                        <th class="border-bottom-0">Visited Camapaigns</th>--}}
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

    {{--  statrt modal restore all Group  --}}
    <div class="modal fade" id="restore_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Restore Groups
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 style="color:#fff">Are You Sure ?</h6>
                    <input class="text" type="hidden" id="restore_all_id" name="restore_all_id" value=''>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn Delete hvr-sweep-to-right"
                            data-dismiss="modal">Close</button>
                    <button type="button" id="submit_restore_all" class="btn Active hvr-sweep-to-right">Restore</button>
                </div>
            </div>
        </div>
    </div>

    {{--  statrt modal restore all Group  --}}
    <div class="modal fade" id="visit_campaigns_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Visited Campaings
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="campaigns_visited">
                    <table id="visited_campaigns_datatable" class="table custom-table">
                        <thead>
                            <tr>
                                <th class="table custom-table"> Campaign Name </th>
                                <th class="table custom-table"> Visit Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--  end modal restore all Group  --}}


    {{--  statrt modal restore all Influe  --}}
    <div class="modal fade" id="restore_influe_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Restore Influencer
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are You Sure ?
                    <input class="text" type="hidden" id="restore_all_influe_id" name="restore_all_influe_id" value=''>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    <button type="button" id="submit_restore_influe_all" class="btn btn-success">Restore</button>
                </div>
            </div>
        </div>
    </div>
    {{--  end modal restore all Influe  --}}

    {{--  statrt modal delete fav all Influe  --}}
    <div class="modal fade" id="delete_fav_influe_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Unfavorite Influencer
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 style="color: #fff;"> Are You Sure ? </h6>
                    <input class="text" type="hidden" id="delete_fav_all_influe_id" name="delete_fav_all_influe_id" value=''>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn Delete hvr-sweep-to-right"
                            data-dismiss="modal">Close</button>
                    <button type="button" id="submit_delete_fav_influe_all" class="btn Active hvr-sweep-to-right">UnFavorite</button>
                </div>
            </div>
        </div>
    </div>
    {{--  end modal delete fav all Influe  --}}


    <style>
        .active_now{
            background: var(--main-bg-color);
            color: white !important;
        }
        .parent-head{
            background: var(--table-header-bg);
            padding: 11px;
            border-radius: 2px;
            font-weight: bold;
            margin-bottom: 11px;
            text-align: center;
            color:white;
        }

        .group-details{
            padding: 10px;
            /* border-bottom: 1px solid #1a243a; */
        }
        .group-details-restore{
            padding: 10px;
            /* border-bottom: 1px solid #1a243a; */
        }
        .group-noFound{
            padding: 10px;
            border-bottom: 1px solid #ced4db;
        }
        .group-details .row span{
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .group-noFound .row span{
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .group-details-restore .row span{
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .main-profile-overview{
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

        .head-button{
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            margin-bottom: -26px;
            flex-wrap: wrap;
            gap: 6px;
        }
        #append .group-details{
            cursor: pointer;
            color:white;
        }
        #append .group-details-restore{
            cursor: pointer;
            color:white;
        }
        .main-profile-social-list{
            overflow-x: hidden;
            height: 350px;
        }
        .btn_group{
            margin-top: 5px;
            text-align: center;
        }
        .profile{
            width: 100%;
            justify-content: flex-start;
            background: var(--body-bg-color);
            padding: 10px;
            border-radius: 20px;
        }
        .parent_nav .active{
            background: VAR(--main-bg-color);
            color: white !important;
        }
        .tapsli{
            padding: 8px 14px;
            border-radius: 23px;
            border: 3px solid #333;
            color: #fff !important;
            padding-left: 8px;
            padding-right: 12px;
            margin-left: 2px;
        }
        .tapsli a{
            color:white;
            background: transparent !important;
        }

        .main-profile-social-list::-webkit-scrollbar {
            width: 2px;
        }
        .main-profile-social-list::-webkit-scrollbar-track {
            background:#131313;
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
