

<div class="col-md-6 _input__text">
                        <label>
                            Select box here <span class="text-danger">*</span>
                            <select class="form-control select2" name="objective_id" value=""
                                id="objective_id" aria-label=".form-select-lg example" style="width:100% !important"
                                onchange="showToggleButton(this)">
                                <option disabled selected>Select</option>

                                @foreach ($objective as $object)
                                    <option data-change="{{ $object->dataoption }}" value="{{ $object->id }}">
                                        {{ $object->title }}</option>
                                @endforeach

                            </select>
                        </label>
                    </div>
                    <div class="pltform_switch col-md-12 _input__checkbox mt-3">
                        @foreach ($objective as $dataObjects)
                            @foreach ($dataObjects->names as $index => $dataObject)
                                <div class="custom-switch object_{{ $dataObjects->dataoption }}"
                                    style="display: none; padding:0rem !important">
                                    <label>
                                        <input
                                        class="customSwitch2 custom_{{ $dataObject['id'] }}  coverage_{{ $dataObject['title'] }}_{{ $dataObject['id']}}" type="checkbox"
                                            name="coverage[]" value="{{ $dataObject['id'] }}"
                                            id="coverage">
                                        {{ $dataObject['title'] }}

                                    </label>
                                    <div class="customSwitch2"></div>

                                    <div class="col-md-12 card coverage-container  coverage-container_{{ $dataObject['title'] }}_{{ $dataObject['id']}}" id="coverage-container" style="padding:1rem;">
                                        <div class="container-fluid gift" style="background-color:transparent;">
                                            <div class="row">

                                                @foreach (getCampaignCoverageChannels() as $campaignCoverageStatus)
                                                    <div class="col-md-6 cover-item coverge-item_{{ $campaignCoverageStatus->title }}_{{ $dataObject['title'] }}_{{ $dataObject['id']}}">
                                                        <div class="_input__checkbox">
                                                            <label>
                                                                <input value="{{ $campaignCoverageStatus->id }}"
                                                                    name="channel_id_{{ $dataObject['id'] }}[]"
                                                                    class="channel_id_{{ $campaignCoverageStatus->title }}_{{ $dataObject['title'] }}_{{ $dataObject['id']}}"
                                                                    type="checkbox" id="channel_id_{{ $dataObject['title'] }}"
                                                                    onclick="togglechangeditem(this,'{{ $campaignCoverageStatus->title }}_{{ $dataObject['title'] }}_{{ $dataObject['id']}}')"
                                                                   >
                                                                {{ $campaignCoverageStatus->title }}
                                                            </label>
                                                             <div class="channel_id"></div>
                                                        </div>

                                                        <div class="coverage-content coverage-content_{{ $campaignCoverageStatus->title }}_{{ $dataObject['title'] }}_{{ $dataObject['id']}}">
                                                            <div class="_input__checkbox">
                                                                <label>
                                                                    <input type="radio"
                                                                        name="main_channel_{{ $campaignCoverageStatus->title }}_{{ $dataObject['id'] }}"
                                                                        class="main_channel">
                                                                    main channel
                                                                </label>
                                                            </div>
                                                            @foreach ($campaignCoverageStatus->objectives as $index => $data)
                                                                <div class="post-type-container">
                                                                    <div class="_input__checkbox post-type-item">
                                                                        <label>
                                                                            <input type="checkbox"
                                                                                value="{{ $data['key'] }}"
                                                                                class="type_share_{{ $data['value'] }}_{{ $campaignCoverageStatus->title }}_{{ $dataObject['id'] }}"
                                                                                id="type_share"
                                                                                onclick="toogleposttype(this,'{{ $data['value'] }}_{{ $campaignCoverageStatus->title }}_{{ $dataObject['id'] }}')"

                                                                                name="type_share_{{ $campaignCoverageStatus->title }}_{{ $dataObject['id'] }}[]">
                                                                            {{ $data['value'] }}
                                                                        </label>

                                                                        <div class="content">
                                                                            @if ($data['value'] != 'video')
                                                                                @foreach ($data['post_type'] as $post)
                                                                                    <label>
                                                                                        <input type="checkbox"
                                                                                            value="{{ $post['id'] }}"
                                                                                            name="share_post_type_{{ $data['value'] }}_{{ $campaignCoverageStatus->title }}_{{ $dataObject['id'] }}[]"
                                                                                            class="share_post_type_{{ $data['value'] }}_{{ $campaignCoverageStatus->title }}_{{ $dataObject['id'] }}"
                                                                                            onclick="handlerequestcheckbox(this,'{{ $campaignCoverageStatus->title }}_{{ $dataObject['title'] }}_{{ $dataObject['id']}}',
                                                                                            '{{ $data['value'] }}_{{ $campaignCoverageStatus->title }}_{{ $dataObject['id'] }}',
                                                                                            '{{ $dataObject['title'] }}_{{ $dataObject['id']}}')"
                                                                                            >
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
