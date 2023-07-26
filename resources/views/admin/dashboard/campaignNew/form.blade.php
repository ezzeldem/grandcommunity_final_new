


<div class="row row-sm">
    <div class="col-12">
        <h5><i class="fas fa-link"></i> Campaign</h5>
        <div class="row">
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                        <p>Step 1</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                        <p>Step 2</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                        <p>Step 3</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                        <p>Step 4</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-5" type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
                        <p>Step 5</p>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="setup-content" id="step-1">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Campaign Name : <span class="text-danger">*</span></label>
                                {{-- {!! Form::text('name',null,['class' =>'form-control '.($errors->has('name') ? 'parsley-error' : null),'placeholder'=> 'Enter Campaign Name','id'=>'name' ]) !!} --}}
                                <input name="name" class="form-control"  placeholder='Enter Campaign Name'
                                    id="name" value="">
                                @error('name')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>



                        <div class="col-md-6 mt-4 brand_data_append" style="display: none;">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Countries: <span class="text-danger">*</span></label>
                                {!! Form::select('country_id[]', $brand_countries, null, [
                                    'class' => 'form-control select2 ' . ($errors->has('country_id') ? 'parsley-error' : null),
                                    'data-show-subtext' => 'true',
                                    'data-live-search' => 'true',
                                    'id' => 'country_id',
                                    'multiple',
                                    'style' => 'width:100%',
                                ]) !!}
                                @error('country_id')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-12">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mt-4 brand_data_append" style="display:none;">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Brands : <span class="text-danger">*</span></label>
                                {!! Form::select('sub_brand_id', subBrands(@$campaign->brand_id), null, [
                                    'class' => 'form-control select2 ' . ($errors->has('sub_brand_id') ? 'parsley-error' : null),
                                    'data-show-subtext' => 'true',
                                    'data-live-search' => 'true',
                                    'id' => 'sub_brand_id',
                                    'style' => 'width:100%',
                                ]) !!}
                                @error('sub_brand_id')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        @if (request()->get('brand'))
                            <div class="col-lg-4 col-md-6 col-sm-12 mt-4">
                                <div class="form-group mg-b-0">
                                    <label class="form-label"> Brand : <span class="text-danger">*</span></label>
                                    {!! Form::select('brand_id', brands(), request()->get('brand'), [
                                        'class' => 'form-control select2 ' . ($errors->has('brand_id') ? 'parsley-error' : null),
                                        'data-show-subtext' => 'true',
                                        'data-live-search' => 'true',
                                        'id' => 'brand_id',
                                        'placeholder' => 'Select',
                                    ]) !!}
                                    @error('brand_id')
                                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <div class="col-lg-4 col-md-6 col-sm-12 mt-4">
                                <div class="form-group mg-b-0">
                                    <label class="form-label"> Brand : <span class="text-danger">*</span></label>
                                    {!! Form::select('brand_id', brands(), null, [
                                        'class' => 'form-control select2 ' . ($errors->has('brand_id') ? 'parsley-error' : null),
                                        'data-show-subtext' => 'true',
                                        'data-live-search' => 'true',
                                        'id' => 'brand_id',
                                        'placeholder' => 'Select',
                                    ]) !!}
                                    @error('brand_id')
                                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="form-group mt-4  col-md-6">
                            <label class="form-label"> Preferred Gender: <span class="text-danger">*</span></label>
                            {!! Form::select('gender', preferred_gender(), null, [
                                'class' => 'form-control select2 ' . ($errors->has('gender') ? 'parsley-error' : null),
                                'data-show-subtext' => 'true',
                                'data-live-search' => 'true',
                                'id' => 'gender',
                                'placeholder' => 'select gender',
                            ]) !!}
                            @error('gender')
                                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul>
                            @enderror
                        </div>


                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label"> Voucher Is Provided : <span
                                        class="text-danger">*</span></label>
                                {!! Form::select('has_voucher', has_voucher(), null, [
                                    'class' => 'form-control select2 ' . ($errors->has('has_voucher') ? 'parsley-error' : null),
                                    'data-show-subtext' => 'true',
                                    'data-live-search' => 'true',
                                    'id' => 'has_voucher',
                                    'placeholder' => 'Select',
                                ]) !!}
                                @error('has_voucher')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-4 brand_data_append" style="display:none;">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Branches : <span class="text-danger">*</span></label>
                                {!! Form::select('branch_ids[]', branches(), null, [
                                    'class' => 'form-control select2 ' . ($errors->has('branch_ids') ? 'parsley-error' : null),
                                    'data-show-subtext' => 'true',
                                    'data-live-search' => 'true',
                                    'id' => 'branch_ids',
                                    'multiple',
                                    'style' => 'width:100%',
                                ]) !!}
                                @error('branch_ids')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>


                        <div class="col-lg-4 col-12 col-sm-12 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Status: <span class="text-danger">*</span></label>
                                {!! Form::select('status', campaignStatus(), null, [
                                    'class' => 'form-control select2 ' . ($errors->has('status') ? 'parsley-error' : null),
                                    'data-show-subtext' => 'true',
                                    'data-live-search' => 'true',
                                    'id' => 'status',
                                    'placeholder' => 'Select',
                                    'style' => 'width:100% !important',
                                ]) !!}
                                @error('status')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Campaign Type: <span class="text-danger">*</span></label>
                                {!! Form::select('campaign_type', campaignType(), null, [
                                    'class' => 'form-control select2 ' . ($errors->has('campaign_type') ? 'parsley-error' : null),
                                    'data-show-subtext' => 'true',
                                    'data-live-search' => 'true',
                                    'id' => 'campaign_type',
                                    'placeholder' => 'select type',
                                    'style' => 'width:100% !important',
                                ]) !!}
                                @error('campaign_type')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Total Influencers: <span
                                        class="text-danger">*</span></label>
                                {!! Form::number('influencer_count', null, [
                                    'class' => 'form-control ' . ($errors->has('influencer_count') ? 'parsley-error' : null),
                                    'placeholder' => 'Enter Total Number Of Influencers',
                                    'id' => 'influencer_count',
                                    'min' => '0',
                                ]) !!}
                                @error('influencer_count')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 mt-4">
                            <div class="form-group mg-b-0 influencer_per_day">
                                <label class="form-label">Daily Influencers :</label>
                                {!! Form::number('influencer_per_day', null, [
                                    'class' => 'form-control ' . ($errors->has('influencer_per_day') ? 'parsley-error' : null),
                                    'placeholder' => 'Enter Number Of Influencers Per Day',
                                    'id' => 'influencer_per_day',
                                    'min' => '0',
                                ]) !!}
                                @error('influencer_per_day')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>


                        {{-- <div class="col-lg-4 col-md-6 col-sm-12 mt-4"  style="display: none">
                            <div class="form-group">
                                <label class="form-label">Confirmation Link: <span class="text-danger">*</span></label>
                                {!! Form::url('confirmation_link',null,['class' =>'form-control link-input'.($errors->has('confirmation_link') ? 'parsley-error' : null),'placeholder'=> 'Enter confirmation Link','id'=>'confirmation_link' ]) !!}
                                @error('confirmation_link')
                                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="col-lg-4 col-md-6 col-sm-12 mt-4" style="display: none">
                            <div class="form-group">
                                <label class="form-label">Delivery Confirmation Link: <span
                                        class="text-danger">*</span></label>
                                {!! Form::url('confirmation_delivery_link', null, [
                                    'class' => 'form-control link-input' . ($errors->has('confirmation_delivery_link') ? 'parsley-error' : null),
                                    'placeholder' => 'Enter confirmation delivery Link',
                                    'id' => 'confirmation_delivery_link',
                                ]) !!}
                                @error('confirmation_delivery_link')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mt-4" style="display: none">
                            <div class="form-group">
                                <label class="form-label">Visit Coverage Link: <span
                                        class="text-danger">*</span></label>
                                {!! Form::url('visit_coverage', null, [
                                    'class' => 'form-control link-input ' . ($errors->has('visit_coverage') ? 'parsley-error' : null),
                                    'placeholder' => 'Enter visit coverage Link',
                                    'id' => 'visit_coverage',
                                ]) !!}
                                @error('visit_coverage')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mt-4" style="display: none">
                            <div class="form-group">
                                <label class="form-label">Delivery Coverage Link: <span
                                        class="text-danger">*</span></label>
                                {!! Form::url('delivery_coverage', null, [
                                    'class' => 'form-control link-input ' . ($errors->has('delivery_coverage') ? 'parsley-error' : null),
                                    'placeholder' => 'Enter delivery coverage Link',
                                    'id' => 'delivery_coverage',
                                ]) !!}
                                @error('delivery_coverage')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mt-4" style="display: none">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Visit Start Date: <span class="text-danger">*</span></label>
                                {!! Form::text('visit_start_date', null, [
                                    'class' => 'form-control' . ($errors->has('visit_start_date') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Select',
                                    'id' => 'visit_start_date',
                                    'min' => date('Y-m-d'),
                                ]) !!}

                                @error('visit_start_date')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mt-4" style="display: none">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Visit End Date: <span class="text-danger">*</span></label>
                                {!! Form::text('visit_end_date', null, [
                                    'class' => 'form-control' . ($errors->has('visit_end_date') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Select',
                                    'id' => 'visit_end_date',
                                    'min' => date('Y-m-d'),
                                ]) !!}
                                @error('visit_end_date')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mt-4"id="datarem" style="display: none">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Delivery Start Date: <span
                                        class="text-danger">*</span></label>
                                {!! Form::text('deliver_start_date', null, [
                                    'class' => 'form-control date-input ' . ($errors->has('deliver_start_date') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Select',
                                    'id' => 'deliver_start_date datetimepicker5',
                                    'min' => date('Y-m-d'),
                                ]) !!}
                                @error('deliver_start_date')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mt-4" style="display: none">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Delivery End Date : <span
                                        class="text-danger">*</span></label>
                                {!! Form::text('deliver_end_date', null, [
                                    'class' => 'form-control  date-input ' . ($errors->has('deliver_end_date') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Select',
                                    'id' => 'deliver_end_date',
                                    'min' => date('Y-m-d'),
                                ]) !!}
                                @error('deliver_end_date')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>





                    </div>

                    <input type="submit" name="submit" class="btn btn-primary nextBtn btn-lg pull-right"
                        value="Next">
                    <input type="button" id="view_data" class="btn btn-primary" value="View data">
                </div>








                {{-- step 2 --}}

                <div class="col-12 mt-4">
                    <div class=" setup-content" id="step-2">
                        <div class="row">



                            <div class="col-md-6 mt-4">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Min story: <span class="text-danger">*</span></label>
                                    {!! Form::number('min_story', null, [
                                        'class' => 'form-control ' . ($errors->has('min_story') ? 'parsley-error' : null),
                                        'placeholder' => 'Enter Total Minimum Story',
                                        'id' => 'min_story',
                                        'min' => '0',
                                    ]) !!}
                                    @error('min_story')
                                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-4 mt-4">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Objective: <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="objective_id"    id="objective_id" aria-label=".form-select-lg example" style="width:100% !important" onchange="showToggleButton(this)">
                                        <option disabled selected>Select</option>
                                        @foreach ($objective as $object)
                                        <option data-change="{{$object->dataoption}}" value="{{$object->id}}">{{$object->title}}</option>
                                        @endforeach

                                      </select>

                                    @error('objective_id')
                                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 main_platform">
                                <div class="platform mt-3 mb-3">
                                    <div class="row">


                                        <div class="col-md-12 but-toogle">
                                            <div class="pltform_switch d-flex justify-content-start align-start flex-row" style="gap: 10px">
                                                @foreach ($objective as  $dataObjects)
                                                @foreach ($dataObjects->names as $index=>$dataObject)
                                                <div class="custom-control custom-switch object_{{$dataObjects->dataoption}}" style="display: none">
                                                    <input type="checkbox" class="custom-control-input customSwitch2" value="false" id="{{$dataObject['random']}}">
                                                    <label class="custom-control-label" for="{{$dataObject['random']}}">{{$dataObject['title']}}</label>
                                                </div>
                                                @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-12 platform-items" style="display: none;width: 300px;">
                                            <div class="platform-item mb-4" style="width: 300px;">
                                                @foreach (getCampaignCoverageChannels() as $fromType)
                                                <div class="form-check mb-2">
                                                    <input name="channel_id[]" class="form-check-input inlineCheckbox1 platform-item-check_{{$fromType->title}}" onchange="showSocialPlatform('{{$fromType->title}}')" type="checkbox" id="platform_type" value="{{$fromType->id}}">
                                                    <label class="form-check-label" for="inlineCheckbox1">{{$fromType->title}}</label>
                                                   <span class="select2"></span>
                                                </div>
                                                @endforeach
                                            </div>
                                            @error('platform_type')
                                            <ul class="parsley-errors-list filled  text-danger"
                                                id="parsley-id-11">
                                                <li class="parsley-required">{{ $message }}</li>
                                            </ul>
                                        @enderror
                                        </div>

                                        @foreach (getCampaignCoverageChannels() as $campaignCoverageStatus)
                                        <div class="col-md-12 platform_type display_{{$campaignCoverageStatus->title}}" style="display: none;">
                                            <div class="platform-item" style=" width: 450px;">
                                                <h6 class="mb-4">{{$campaignCoverageStatus->title}}</h6>
                                                <div class=" platform-item-check data" >
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                        <label class="form-check-label" for="exampleRadios2">
                                                          Main channel
                                                        </label>

                                                    </div>

                                                </div>
                                                <div class="platform-item-check mt-3 social_type">
                                                    @foreach ($campaignCoverageStatus->objectives as $index => $data)


                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" style="display: flex;align-items:center;justify-content:flex-start">
                                                            <input id="type_share" name="type_share_{{$campaignCoverageStatus->title}}[]" class="form-check-input" onchange="showShare(this,'post_specify_{{$index}}_{{$campaignCoverageStatus->title}}')" type="checkbox"  value="{{$data['key']}}">
                                                            {{$data['value']}}
                                                        </label>
                                                    <span class="select2"></span>
                                                    </div>
                                                    @endforeach

                                                </div>

                                                <h6 class="mt-4 mb-0"> Posts type: </h6>
                                                @foreach ($campaignCoverageStatus->objectives as $index => $data)
                                                @foreach ($data['post_type'] as $post)

                                                <div  style="visibility: hidden;height:0px;transition:all 0.2s ease-in-out;opacity:0;"  class="platform-item-check post_type post_specify_{{$index}}_{{$campaignCoverageStatus->title}}">
                                                    <div class="form-check form-check-inline">
                                                        <input id="share_post_type" value="{{$post['id']}}" name="share_post_type_{{$data['value']}}_{{$campaignCoverageStatus->title}}[]"  class="form-check-input" type="checkbox">
                                                        <label class="form-check-label" for="inlineCheckbox6">{{$post['name']}}</label>
                                                        <span class="select2"></span>
                                                    </div>
                                                    <span class="select2"></span>
                                                </div>

                                                @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            @if (isset($secrets))

                                <div class="col-12 mt-4" id="brand-secrets">
                                    <h5><i class="fas fa-link"></i>campaign secrets</h5>
                                    <hr>
                                    {{--            <button class="btn btn-warning float-right add-secret" type="button">Add secret</button> --}}
                                    <div class="clearfix"></div>

                                    {{--            @if (isset($secrets)) --}}

                                    @forelse($secrets as $secret)
                                        <div class="row secrets"
                                            data-county-id="{{ @$secret->campaignCountry->country_id }}">
                                            <div class="col-8">
                                                <div class="form-group mg-b-0">
                                                    <label
                                                        class="form-label">{{ @$secret->campaignCountry->country->name }}
                                                        secret: <span class="text-danger">*</span></label>
                                                    {!! Form::text('secret[' . @$secret->campaignCountry->country_id . ']', $secret->secret, [
                                                        'data-id' => $secret->campaignCountry->country_id,
                                                        'class' => 'form-control secret ' . ($errors->has('secret') ? 'parsley-error' : null),
                                                        'placeholder' => 'Enter secret',
                                                        'id' => 'secret_' . $secret->campaignCountry->country_id,
                                                    ]) !!}

                                                    @error('secret')
                                                        <ul class="parsley-errors-list filled  text-danger"
                                                            id="parsley-id-11">
                                                            <li class="parsley-required">{{ $message }}</li>
                                                        </ul>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-4 mt-4">
                                                <div class="form-group">
                                                    <button class="btn btn-success generate-secret"
                                                        type="button">generate secret</button>
                                                    <button class="btn btn-danger del-secret" type="button"
                                                        style="display: none"><i class="icon-trash-2"></i></button>
                                                </div>
                                            </div>
                                            <div class="permissions mt-4">

                                            </div>
                                        </div>
                                    @empty
                                        @foreach ($campaign->campaignCountries as $country)
                                            <div class="row secrets" data-county-id="{{ @$country }}">
                                                <div class="col-8">
                                                    <div class="form-group mg-b-0">
                                                        <label class="form-label">{{ @$country->country->name }}
                                                            secret: <span class="text-danger">*</span></label>
                                                        {!! Form::text('secret[' . @$country->country_id . ']', null, [
                                                            'data-id' => $country->country_id,
                                                            'class' => 'form-control secret ' . ($errors->has('secret') ? 'parsley-error' : null),
                                                            'placeholder' => 'Enter secret',
                                                            'id' => 'secret_' . $country->country_id,
                                                        ]) !!}

                                                        @error('secret')
                                                            <ul class="parsley-errors-list filled  text-danger"
                                                                id="parsley-id-11">
                                                                <li class="parsley-required">{{ $message }}</li>
                                                            </ul>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-4 mt-4">
                                                    <div class="form-group">
                                                        <button class="btn btn-success generate-secret"
                                                            type="button">generate secret</button>
                                                        <button class="btn btn-danger del-secret" type="button"
                                                            style="display: none"><i
                                                                class="icon-trash-2"></i></button>
                                                    </div>
                                                </div>
                                                <div class="permissions mt-4">

                                                </div>
                                            </div>
                                        @endforeach
                                    @endforelse
                                </div>
                            @else
                                <div class="col-12 mt-4" id="brand-secrets" style="display: none">


                                </div>
                            @endif

                            <div class="col-12 mt-4" style="display: none">
                                <h5><i class="fas fa-link"></i> countries list</h5>
                                <hr>
                                <div class="row" id="countries_list">
                                </div>
                            </div>

                            <div class="container-fluid" id="voucher_block" style="display: none">
                            </div>

                        </div>
                        <input type="submit" name="submit" class="btn btn-primary nextBtn btn-lg pull-right"
                            value="Next">
                        <input type="button" id="view_data" class="btn btn-primary" value="View data">
                    </div>
                </div>

                <div class="col-12">
                    <div class="row setup-content" id="step-3">
                        <div class="col-md-6 col-sm-12 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label"> Guests Are Allowed: <span
                                        class="text-danger">*</span></label>
                                {!! Form::select('has_guest', has_guests(), null, [
                                    'class' => 'form-control select2 ' . ($errors->has('has_guest') ? 'parsley-error' : null),
                                    'data-show-subtext' => 'true',
                                    'data-live-search' => 'true',
                                    'id' => 'has_guest',
                                    'placeholder' => 'Select',
                                ]) !!}
                                @error('has_guest')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>



                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0 lablabla">
                                <label class="form-label">En Note: <span class="text-danger">*</span></label>
                                {!! Form::textarea('camp_note[0][0]', null, [
                                   'class' =>'form-control '.($errors->has('camp_note.0.0') ? 'parsley-error' : null) ,
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Enter English Company Note ',
                                    'id' => 'campaign_note_english',
                                    'rows' => 2,
                                    'id'=>'camp_note.0.0'
                                ]) !!}
                                 @error('camp_note.0.0')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                                <span class="select2"></span>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Ar Note: <span class="text-danger">*</span></label>
                                {!! Form::textarea('camp_note[0][1]', null, [
                                    'class' => 'form-control ' . ($errors->has('campaign_note_arabic') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Enter Arabic Company Note ',
                                    'id' => 'campaign_note_arabic',
                                    'rows' => 2,
                                    'id'=>'camp_note.0.1',
                                ]) !!}
                                @error('camp_note.0.1')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                                <span class="select2"></span>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">En brief: <span class="text-danger">*</span></label>
                                {!! Form::textarea('brief[0][0]', null, [
                                    'class' => 'form-control ' . ($errors->has('brief_en') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Enter English Brief ',
                                    'id' => 'brief.0.0',
                                    'rows' => 2,
                                ]) !!}
                                 @error('brief.0.0')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                                <span class="select2"></span>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Ar brief: <span class="text-danger">*</span></label>
                                {!! Form::textarea('brief[0][1]', null, [
                                    'class' => 'form-control ' . ($errors->has('brief_ar') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Enter Arabic Brief ',
                                    'id' => 'brief.0.1',
                                    'rows' => 2,
                                ]) !!}
                                @error('brief.0.1')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">En Campaign brief: <span
                                        class="text-danger">*</span></label>
                                {!! Form::textarea('camp_brief[0][0]', null, [
                                    'class' => 'form-control' . ($errors->has('campaign_brief_en') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Enter English Company Brief ',
                                    'id' => 'camp_brief.0',
                                    'rows' => 2,
                                ]) !!}
                                @error('camp_brief.0.0')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Ar Campaign brief: <span
                                        class="text-danger">*</span></label>
                                {!! Form::textarea('camp_brief[0][1]', null, [
                                    'class' => 'form-control camp_brief.0.1' . ($errors->has('campaign_brief_ar') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Enter Arabic Company Brief ',
                                    'id' => 'camp_brief',
                                    'rows' => 2,
                                ]) !!}
                                @error('camp_brief.0.1')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Invetation: <span class="text-danger">*</span></label>
                                {!! Form::textarea('camp_invetation', null, [
                                    'class' => 'form-control ' . ($errors->has('invetation') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Enter Invetation',
                                    'id' => 'invetation',
                                    'rows' => 2,
                                ]) !!}
                                @error('invetation')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>



                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Campaign Message: <span class="text-danger">*</span></label>
                                {!! Form::textarea('campaign_msg', null, [
                                    'class' => 'form-control ' . ($errors->has('campaign_msg') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Enter Company Message',
                                    'id' => 'campaign_msg',
                                    'rows' => 2,
                                ]) !!}
                                @error('campaign_msg')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Influencers Script: <span
                                        class="text-danger">*</span></label>
                                {!! Form::textarea('influencers_script', null, [
                                    'class' => 'form-control ' . ($errors->has('influencers_script') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Enter Influencers Script',
                                    'id' => 'influencers_script',
                                    'rows' => 2,
                                ]) !!}
                                @error('influencers_script')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" name="submit" class="btn btn-primary nextBtn btn-lg pull-right"
                                value="Next">
                            <button style="width: 150px;" class="btn btn-primary pd-x-20 mg-t-10"
                                id="submit-campaign" type="submit">
                                Save
                            </button>
                        </div>
                    </div>

                </div>
                <div class="col-12">
                    <div class="row setup-content" id="step-4">
                        <div class="col-md-12">
                            <div class="form-group mg-b-0">
                                <div class="container-fluid">
                                    <div class="row">
                                        @forelse ($chick_lists as $chicklist)
                                            <div class="col-md-4">
                                                <label style="font-size: 15px;display: flex;align-items: center;justify-content: flex-start;gap: 9px;padding: 1rem 0.4rem;box-shadow: 0px 1px 4px 2px #111111;border-radius: 4px;margin: 0.7rem 0rem;border-left: 2px solid #d7af3269;">
                                                    <input
                                                    name="chicklist[]"
                                                    class="check_list"
                                                    type="checkbox"
                                                    value="{{ $chicklist->id }}"
                                                    style=" accent-color: #d7af32; transform: scale(1.1); ">
                                                       {{ $chicklist->name }}
                                                </label>

                                            </div>
                                        @empty
                                    </div>
                                </div>
                                <p>no data</p>
                                @endforelse
                                @error('chicklist.*')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" name="submit" class="btn btn-primary nextBtn btn-lg pull-right"
                                value="Next">

                                <input type="button" id="view_data" class="btn btn-primary" value="View data">

                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row setup-content" id="step-5">
                        <div class="col-md-6 mt-4">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Influencers Script: <span
                                        class="text-danger">*</span></label>
                                {!! Form::textarea('influencers_script', null, [
                                    'class' => 'form-control ' . ($errors->has('influencers_script') ? 'parsley-error' : null),
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Enter Influencers Script',
                                    'id' => 'influencers_script',
                                    'rows' => 2,
                                ]) !!}
                                @error('influencers_script')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">

                            <button style="width: 150px;" class="btn btn-primary pd-x-20 mg-t-10"
                                id="submit-campaign" type="submit">
                                Save
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>



    </div>
</div>

