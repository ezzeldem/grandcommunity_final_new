<div class="col-md-6 _input__text">
    <label>
        Select box here <span class="text-danger">*</span>
        <select class="form-control select2" name="objective_id" value="" id="objective_id"
            aria-label="form-select-lg example" style="width:100% !important" onchange="showToggleButton(this)">
            <option disabled selected>Select</option>

            @foreach ($objective as $object)
                <option data-change="{{ $object->dataoption }}" value="{{ $object->id }}"
                    {{ $campaign->objective_id == $object->id ? 'selected' : null }}>
                    {{ $object->title }}</option>
            @endforeach

        </select>
    </label>
</div>
<div class="pltform_switch col-md-12 _input__checkbox mt-3">
    @foreach ($objective as $dataObjects)
        @foreach ($dataObjects->names as $index => $dataObject)
            <div class="custom-switch object_{{ $dataObjects->dataoption }}"
                style="display:none; padding:0rem !important">
                <label>
                    <input class="customSwitch2 custom_{{ $dataObject['id'] }}" type="checkbox" name="coverage[]"
                        value="{{ $dataObject['id'] }}" id="{{ $dataObject['random'] }}"
                        {{ in_array($dataObject['id'], $campaign->campaign_type_channel) ? 'checked' : null }}>
                    {{ $dataObject['title'] }}
                </label>



                <div class="col-md-12 card coverage-container" style="padding:1rem;">
                    <div class="container-fluid gift" style="background-color:transparent;">
                        <div class="row">

                            @foreach (getCampaignCoverageChannels() as $campaignCoverageStatus)
                                <div class="col-md-6 cover-item">
                                    <div class="_input__checkbox">
                                        <label>
                                            <input value="{{ $campaignCoverageStatus->id }}"
                                                name="channel_id_{{ $dataObject['id'] }}[]" type="checkbox"
                                                id=""
                                                @foreach ($campaign->coverageChannel as $chaa)
                                                                @if ($chaa->campaign_type == $dataObject['id'] && $chaa->channel_id == $campaignCoverageStatus->id)
                                                                   checked
                                                                   @endif @endforeach>
                                            {{ $campaignCoverageStatus->title }}
                                        </label>
                                    </div>

                                    <div class="coverage-content">
                                        <div class="_input__checkbox">
                                            <label>
                                                <input type="radio"
                                                    name="main_channel_{{ $dataObject['id'] }}"
                                                    class="main_channel">
                                                main channel
                                            </label>
                                        </div>
                                        @foreach ($campaignCoverageStatus->objectives as $index => $data)
                                            <div class="post-type-container">
                                                <div class="_input__checkbox post-type-item">
                                                    <label>
                                                        <input type="checkbox" value="{{ $data['key'] }}"
                                                            name="type_share_{{ $campaignCoverageStatus->title }}_{{ $dataObject['id'] }}[]"id=""
                                                            @foreach ($campaign->coverageChannel as $chaa)
                                                                                    @if ($chaa->campaign_type == $dataObject['id'] && $chaa->channel_id == $campaignCoverageStatus->id)
                                                                                    @if ($chaa->posts != null && $data['value'] == 'posts')
                                                                                    checked
                                                                                    @elseif($chaa->reels != null && $data['value'] == 'reels')
                                                                                    checked
                                                                                      @elseif($chaa->stories != null && $data['value'] == 'story')
                                                                                    checked
                                                                                        @elseif($chaa->video != null && $data['value'] == 'video')
                                                                                    checked
                                                                                   @endif
                                                                                   @endif @endforeach>
                                                        {{ $data['value'] }}
                                                    </label>

                                                    <div class="content">
                                                        @if ($data['value'] != 'video')
                                                            @foreach ($data['post_type'] as $post)
                                                                <label>
                                                                    <input type="checkbox" value="{{ $post['id'] }}"
                                                                        name="share_post_type_{{ $data['value'] }}_{{ $campaignCoverageStatus->title }}_{{ $dataObject['id'] }}[]"
                                                                        id=""
                                                                        @foreach ($campaign->coverageChannel as $chaa)
                                                                        @if ($chaa->campaign_type == $dataObject['id'] && $chaa->channel_id == $campaignCoverageStatus->id)
                                                                           @if ($chaa->posts != null && $data['value'] == 'posts')
                                                                                      @if (in_array($post['id'], $chaa->posts))
                                                                                       checked
                                                                                       @endif
                                                                                    @elseif($chaa->reels != null && $data['value'] == 'reels')
                                                                                      @if (in_array($post['id'], $chaa->reels))
                                                                                       checked
                                                                                       @endif
                                                                                      @elseif($chaa->stories != null && $data['value'] == 'story')
                                                                                     @if (in_array($post['id'], $chaa->stories))
                                                                                       checked
                                                                                       @endif
                                                                                   @endif



                                                                        @endif @endforeach>
                                                                    {{ $post['name'] }}
                                                                </label>
                                                            @endforeach
                                                        @endif


                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    @endforeach

</div>
