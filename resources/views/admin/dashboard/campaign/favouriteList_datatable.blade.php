<div class="cam_all_data">
    <div class="campaign">
        {{-- <a aria-controls="collapseExample" style="margin-left: 55px;margin-top: 20px;" aria-expanded="false" class="btn ripple btn-success" data-toggle="collapse" href="#collapseExample" role="button"> <i class="fas fa-eye mr-2"></i> Show Influencer</a>--}}
        <div class="collapse show" id="collapseExample">
            <div class="row">
                <div class="col-md-12">
                        <div class="card-body">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active campaign-inner" role="tabpanel">
                                            <div class="grand-nav-box">
                                            <ul class="nav nav-tabs card" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#all-camp" role="tab" onClick="campaignSubTypeSwitch(0)">
                                                 All
                                                <span id="count_all" class="badge badge-primary"></span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="confirmation"
                                               href="#confirmed-camp" role="tab" onClick="campaignSubTypeSwitch(1)">
                                                Confirmations
                                                <span id="count_confirmation" class="badge badge-primary"></span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="visit" href="#visit-camp"
                                               role="tab" onClick="campaignSubTypeSwitch(2)">
                                                Visits
                                                <span id="count_visit" class="badge badge-primary"></span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="not_visit" href="#not-visit-camp"
                                               role="tab" onClick="campaignSubTypeSwitch(3)">
                                                Missed Visits
                                                <span id="count_not_visit" class="badge badge-primary"></span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="cancel" href="#cancel-camp"
                                               role="tab" onClick="campaignSubTypeSwitch(4)">
                                                Cancels
                                                <span id="count_cancel" class="badge badge-primary"></span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="coverage" href="#coverage-camp"
                                               role="tab" onClick="campaignSubTypeSwitch(7)">
                                                Coverage
                                                <span id="count_coverage" class="badge badge-primary"></span>
                                            </a>
                                        </li>

{{--                                        <li class="nav-item">--}}
{{--                                            <a class="nav-link" data-toggle="tab" id="campa_complaint" href="#campa_complaint" role="tab" onClick="campaignSubTypeSwitch(10)">--}}
{{--                                                 Complaint--}}
{{--                                                <span id="count_complaint" class="badge badge-primary"></span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="wating" href="#wating-camp"
                                               role="tab" onClick="campaignSubTypeSwitch(5)">
                                                Waiting List
                                                <span id="count_waiting" class="badge badge-primary">
                                                </span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="incorrectCamp"
                                               href="#incorrect-camp" role="tab" onClick="campaignSubTypeSwitch(6)">
                                                Incorrect Attempts
                                                <span id="count_incorrect" class="badge badge-primary"></span>
                                            </a>
                                        </li>

                                </ul>
                                            </div>
                                <div class="tab-pane active camp_sub" id="all-camp" role="tabpanel">
                                    <div class="" id="all-camp-fav-inf-calendar">
                                        <div class="col-12">
                                            <div class="country-tabs card">
                                                <div class="tabs">
                                                    <div id="all-camp-fav-inf-calendar-calendar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="all-camp-fav-inf-table">
                                        <div class="col-12">
                                            <div class="country-tabs card">
                                                <div class="tabs">
                                                    <div class="tabs_Camp mb-2">
                                                        <div class="btn_calendar_list"></div>
                                                        <ul id="tab-links">
                                                            <li><a style="" href="#all" data-sectionId="all"
                                                                   data-countryId="0" class="active tabbb"
                                                                   onClick="appendSectionId(event)">All</a></li>
                                                            @foreach($countries as $country)
                                                                <li>
                                                                    <a style="" href="#{{$country->name}}" class="tabbb"
                                                                       data-sectionId="{{$country->name}}"
                                                                       data-countryId="{{$country->id}}"
                                                                       onClick="appendSectionId(event)"
                                                                       title="{{$country->name}}">
                                                                        <img
                                                                            style="margin-left: 2px; display: inline-block;"
                                                                            src="https://hatscripts.github.io/circle-flags/flags/{{Illuminate\Support\Str::lower($country->code)}}.svg"
                                                                            width="22" class="img-flag">
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="btn_table">
                                                            @if(\App\Models\CampaignInfluencer::count())
                                                                <div class="btn-group" id="importExcelListOne">
                                                                    <button id="importList"
                                                                            style="border-radius:8px;border-radius: 8px;padding: 0.4rem 1rem;width: fit-content;"
                                                                            type="button hvr-sweep-to-right"
                                                                            class="btn dropdown-toggle mr-2"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                        Status
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item camp-status-visit-modal"
                                                                           href="#">Visit</a>
                                                                        <a class="dropdown-item camp-status-confirm-modal"
                                                                           href="#">Confirm</a>
                                                                        <a class="dropdown-item camp-status-missed_visit-modal"
                                                                           href="#">Missed Visit</a>
                                                                        <a class="dropdown-item camp-status-reject-modal"
                                                                           href="#">Reject</a>
                                                                    </div>
                                                                </div>
                                                                <div class="btn-group" id="importExcelList">
                                                                    <button type="button"
                                                                            
                                                                            class="btn dropdown-toggle mr-2"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                        Import
                                                                    </button>

                                                                    <a href="{{route('dashboard.campaign_influencer_export',[$campaign->id])}}"
                                                                       id="export_excel_sheet"
                                                                       class="btn btn-default mr-2 float-right"
                                                                       style="background-color: #363636; color: #ffffff"><span>Export Excel</span></a>

                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item openImportModal"
                                                                           data-modal="CheckList" href="#">Check in
                                                                            List</a>
                                                                        <a class="dropdown-item openImportModal"
                                                                           data-modal="Confirmation" href="#">Confirmation
                                                                            List</a>
                                                                    </div>
                                                                </div>


                                                                <button type="button"
                                                                        
                                                                        id="complign_btn"
                                                                        class="btn dropdown-toggle mr-2"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    Complaint
                                                                </button>

                                                                @can('delete campaigns')
                                                                    <button type="button" class="btn  mr-2 float-right "
                                                                            style="border-radius:8px;" id="dele-All">
                                                                        <i class="fas fa-trash-alt"></i> Delete Selected
                                                                    </button>
                                                                @endcan
                                                                @can('update campaigns')
                                                                    {{-- <button type="button" style="border-radius:8px;" class="btn mr-2 float-right  check-modal">
                                                                        <i class="fas fa-qrcode"></i> Generate Qr/Secret
                                                                    </button> --}}
                                                                @endcan
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <section class="country-visit-active active active2">
                                                    <!-- <h3 style="" class="mt-4">{{$campaign->name}}</h3>
                                                            <span id="campaign_date"> @if($campaign->campaign_type == 0 || $campaign->campaign_type == 2 ) [ {{$campaign->visit_start_date}} / {{$campaign->visit_end_date}} ] @elseif($campaign->campaign_type == 1) [ {{$campaign->deliver_start_date}} / {{$campaign->deliver_end_date}} ] @endif </span> -->
                                                        @include('admin.dashboard.campaign.models.filter_seach')
                                                        <div class="clearfix"></div>
                                                        <div class="table-responsive">
                                                            <div class="zoom-container">
                                                                <button
                                                                    onclick="$('.table-responsive').fullScreenHelper('toggle');"
                                                                    class="zoom-button">
                                                                    <i class="fas fa-expand"></i>
                                                                </button>
                                                            </div>
                                                            <table id="exampleTbl" class="table custom-table resizable"
                                                                   style="width: 100%;">

                                                                <!-- <div class="zoom-container zoom-abs">
                                                                    <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
                                                                        <i class="fas fa-expand"></i>
                                                                    </button>
                                                                </div> -->
                                                                <thead>
                                                                <tr>
                                                                    <th class="border-bottom-0">
                                                                        <input name="select_all" id="select_all"
                                                                               type="checkbox"/>
                                                                    </th>
                                                                    <th class="border-bottom-0">Instagram Username</th>
                                                                    <th class="border-bottom-0">FolderId</th>
                                                                    <th class="border-bottom-0">Full Name</th>
                                                                    <th class="border-bottom-0">Country</th>
                                                                    <th class="border-bottom-0">Visit Date</th>
                                                                    <th class="border-bottom-0">Influencer Coverage</th>
                                                                    <th class="border-bottom-0">Confirmation Date</th>
                                                                    <th class="border-bottom-0">Branches</th>
                                                                    <th class="border-bottom-0">invitations</th>
                                                                    <th class="border-bottom-0">Brief</th>
                                                                    <th class="border-bottom-0">Followers</th>
                                                                    <th class="border-bottom-0">Engagement</th>
                                                                    <th class="border-bottom-0">Added At</th>
                                                                    <th class="border-bottom-0">Snapchat Username</th>
                                                                    <th class="border-bottom-0">Socials</th>
                                                                    <th class="border-bottom-0">Date</th>
                                                                    <th class="border-bottom-0">QR Code Status</th>
                                                                    <th class="border-bottom-0">Influencer Status</th>
                                                                    <th class="border-bottom-0">Coverage Status</th>
                                                                    <th class="border-bottom-0">Coverage Date</th>
                                                                    <th class="border-bottom-0">Reject Reason</th>
                                                                    <th class="border-bottom-0">Languages</th>
                                                                    <th class="border-bottom-0">Coverage Type</th>
                                                                    <th class="border-bottom-0">Rating</th>
                                                                    <th class="border-bottom-0">Complain Status</th>
                                                                    @can('update campaigns')
                                                                        <th class="border-bottom-0">Campaign Info</th>
                                                                    @endcan
                                                                    <th>Actions</th>

                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </section>
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

</div>
<div class="modal fade  show" id="camp_complain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Complaint
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="row mb-4">
                    <div class="col-sm-12 col-md-12" style="width: 478px;height: 102px">
                        <label> Reason</label>
                        <textarea type="text" name="note" class="form-control" id="complaint_note"></textarea>
                        <small class="text-danger"></small><br>

                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-12 col-md-12" style="width: 478px;height: 102px">
                        <label> Date</label>
                        <input name="dateproblem" class="form-control" type="date" id="datePicker">
                        <small class="text-danger"></small><br>
                    </div>
                </div>

            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <div class="btn">
                    <button type="button" id="store_complaint" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
