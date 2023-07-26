<div class="cam_all_data">
    <div class="campaign">
        {{-- <a aria-controls="collapseExample" style="margin-left: 55px;margin-top: 20px;" aria-expanded="false" class="btn ripple btn-success" data-toggle="collapse" href="#collapseExample" role="button"> <i class="fas fa-eye mr-2"></i> Show Influencer</a>--}}
        <div class="collapse show" id="collapseExample">
            <div class="row mt-5">
                <div class="col-md-12">
                    <!-- Nav tabs -->
                    <div class="">
                        <div class="">
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                                @if($campaign->campaign_type == 0 || $campaign->campaign_type == 2 )
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" onClick="campaignTypeSwitch(0)" href="#visit" role="tab">
                                        <i class="fas fa-car"></i> Visit Campaign
                                    </a>
                                </li>
                                @endif
                                @if($campaign->campaign_type == 1 || $campaign->campaign_type == 2 )
                                <li class="nav-item">
                                    <a class="nav-link @if($campaign->campaign_type ==1) active @endif" onClick="campaignTypeSwitch(1)" data-toggle="tab" href="#delivery" role="tab">
                                        <i class="fas fa-plane"></i> Delivery Campaign
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>


                        <div class="card-body">
                            <!-- Tab panes -->
                            <div class="tab-content text-center">
                                <div class="tab-pane active campaign-inner" role="tabpanel">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#all-camp" role="tab" onClick="campaignSubTypeSwitch(0)">
                                                <i class="fas fa-asterisk"></i> All
                                                <span id="count_all" class="badge badge-primary"></span>
                                            </a>
                                        </li>
                                        @if($campaign->campaign_type == 0 || $campaign->campaign_type == 2 )

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="confirmation" href="#confirmed-camp" role="tab" onClick="campaignSubTypeSwitch(1)">
                                                <i class="fas fa-times-circle"></i> 
                                                <span id="count_confirmation" class="badge badge-primary"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="visit" href="#visit-camp" role="tab" onClick="campaignSubTypeSwitch(2)">
                                                <i class="fas fa-check-circle"></i> Visits
                                                <span id="count_visit" class="badge badge-primary"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="not_visit" href="#not-visit-camp" role="tab" onClick="campaignSubTypeSwitch(3)">
                                                <i class="fas fa-times-circle"></i> Missed Visits
                                                <span id="count_not_visit" class="badge badge-primary"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="cancel" href="#cancel-camp" role="tab" onClick="campaignSubTypeSwitch(4)">
                                                <i class="fas fa-times-circle"></i> Cancels
                                                <span id="count_cancel" class="badge badge-primary"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="wating" href="#wating-camp" role="tab" onClick="campaignSubTypeSwitch(5)">
                                                <i class="fas fa-times-circle"></i> Waiting List
                                                <span id="count_waiting" class="badge badge-primary"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" id="incorrectCamp" href="#incorrect-camp" role="tab" onClick="campaignSubTypeSwitch(6)">
                                                <i class="fas fa-times-circle"></i> Incorrect Attempts
                                                <span id="count_incorrect" class="badge badge-primary"></span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                    <div class="tab-pane active camp_sub" id="all-camp" role="tabpanel">
                                        <div class="row p-2">
                                            <div class="col-12">
                                                <div class="country-tabs">
                                                    <div class="tabs">
                                                        <ul id="tab-links">
                                                            <li><a style="border-radius: 18px 0rem 0rem 18px;" href="#all" data-sectionId="all" data-countryId="0" class="active tabbb" onClick="appendSectionId(event)">All</a></li>
                                                            @foreach($countries as $country)
                                                            <li>
                                                                <a style="border-radius: 18px 0rem 0rem 18px;" href="#{{$country->name}}" class="tabbb" data-sectionId="{{$country->name}}" data-countryId="{{$country->id}}" onClick="appendSectionId(event)" title="{{$country->name}}">
                                                                    <img style="margin-left: 2px; display: inline-block;" src="https://hatscripts.github.io/circle-flags/flags/{{Illuminate\Support\Str::lower($country->code)}}.svg" width="22" class="img-flag">
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>

                                                        <section class="country-visit-active active active2">
                                                            <div style="margin-bottom: 70px">
                                                                <h3 style="" class="mt-4">{{$campaign->name}}</h3>
                                                                <span id="campaign_date"> @if($campaign->campaign_type == 0 || $campaign->campaign_type == 2 ) [ {{$campaign->visit_start_date}} / {{$campaign->visit_end_date}} ] @elseif($campaign->campaign_type == 1) [ {{$campaign->deliver_start_date}} / {{$campaign->deliver_end_date}} ] @endif </span>
                                                                @include('admin.dashboard.campaign.models.filter_seach')

                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="btn_table">
                                                                @if(\App\Models\CampaignInfluencer::count())
                                                                <div class="btn-group" id="importExcelListOne">
                                                                    <button id="importList" style="border-radius:8px;border-radius: 8px;padding: 0.4rem 1rem;width: fit-content;" type="button" class="btn dropdown-toggle mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Status
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item camp-status-visit-modal" href="#">Visit</a>
                                                                        <a class="dropdown-item camp-status-confirm-modal" href="#">Confirm</a>
                                                                        <a class="dropdown-item camp-status-missed_visit-modal" href="#">Missed Visit</a>
                                                                        <a class="dropdown-item camp-status-reject-modal" href="#">Reject</a>
                                                                    </div>
                                                                </div>
                                                                <div class="btn-group" id="importExcelList">
                                                                    <button type="button" style="border-radius:8px;padding: 0.4rem 1rem;width: fit-content;" class="btn dropdown-toggle mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Import
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item openImportModal" data-modal="CheckList" href="#">Check in List</a>
                                                                        <a class="dropdown-item openImportModal" data-modal="Confirmation" href="#">Confirmation List</a>
                                                                    </div>
                                                                </div>
                                                                @can('delete campaigns')
                                                                <button type="button" class="btn  mr-2 float-right " style="border-radius:8px;" id="dele-All">
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
                                                            <div class="table-responsive">

                                                                <table id="exampleTbl" class="table custom-table resizable" style="width: 100%;">

                                                                    <!-- <div class="zoom-container zoom-abs">
                                                                        <button onclick="$('.table-responsive').fullScreenHelper('toggle');" class="zoom-button">
                                                                            <i class="fas fa-expand"></i>
                                                                        </button>
                                                                    </div> -->
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="border-bottom-0">
                                                                                <input name="select_all" id="select_all" type="checkbox" />
                                                                            </th>
                                                                            
                                                                            <th class="border-bottom-0">Instagram Username</th>
                                                                            <th class="border-bottom-0">Full Name</th>
                                                                            <th class="border-bottom-0">Country</th>
                                                                            <th class="border-bottom-0">Visit Date</th>
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
</div>
