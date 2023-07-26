<div class="modal fade effect-newspaper show" id="campaign_checklists_modal" tabindex="-1" role="dialog"
     aria-labelledby="campaign_checklists_modal"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="min-width: 850px;">
        <form action="{{route('dashboard.campaigns.updateCampaignQuality', ['campaign_id' => $campaign->id])}}" id="update_campaign_quality_form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title">
                    Quality Review
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mg-b-0">
                            <div class="container-fluid">
                                <div class="row">
                                    @forelse ($chick_lists as $chicklist)

                                        <div class="col-md-4">
                                            <label
                                                style="font-size: 15px;display: flex;align-items: center;justify-content: flex-start;gap: 9px;padding: 1rem 0.4rem;box-shadow: 0px 1px 4px 2px #111111;border-radius: 4px;margin: 0.7rem 0rem;border-left: 2px solid #d7af3269;">
                                                <input name="chicklist[]" class="check_list" type="checkbox"
                                                       value="{{ $chicklist->id }}"
                                                       style=" accent-color: #d7af32; transform: scale(1.1); "
                                                @if(isset($campaign) && !is_null($campaign->campaign_check_list))
                                                    @forelse($campaign->campaign_check_list as $list)
                                                        {{$chicklist->id == $list ? 'checked':null}}
                                                        @empty
                                                        @endforelse
                                                    @endif
                                                >
                                                {{ $chicklist->name }}
                                            </label>

                                        </div>
                                    @empty
                                </div>
                            </div>
                            <p>Empty</p>
                            @endforelse
                            @error('chicklist.*')
                            <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="justify-content: center !important;">
                <div class="btn">
                    <button type="button" class="btn update-campaign-form-btn" data-action="{{route('dashboard.campaigns.updateCampaignQuality', ['campaign_id' => $campaign->id])}}" data-form="#update_campaign_quality_form">Save</button>
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
