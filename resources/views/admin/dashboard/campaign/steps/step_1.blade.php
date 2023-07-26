<div class="row justify-content-center grand-campaign-step">


    <style>
    .grand-campaign-step input,
    .grand-campaign-step textarea,
    .grand-campaign-step select {
    height: unset !important;
    }
    .grand-campaign-step input,
    .grand-campaign-step textarea,
    .grand-campaign-step select,
    .grand-campaign-step .select2-container--default .select2-selection--single .select2-selection__rendered {
    padding: 17px;
    border: 1px solid #6e6e6e !important;
    border-radius: 4px;
    }
    .grand-campaign-step input::-moz-placeholder, .grand-campaign-step textarea::-moz-placeholder, .grand-campaign-step select::-moz-placeholder, .grand-campaign-step .select2-container--default .select2-selection--single .select2-selection__rendered::-moz-placeholder {
    color: #6e6e6e !important;
    }
    .grand-campaign-step input::placeholder,
    .grand-campaign-step textarea::placeholder,
    .grand-campaign-step select::placeholder,
    .grand-campaign-step .select2-container--default .select2-selection--single .select2-selection__rendered::placeholder {
    color: #6e6e6e !important;
    }
    .grand-campaign-step .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 18px !important;
    }
    .grand-campaign-step .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 50px !important;
    }
    .grand-campaign-step .select2-container--default .select2-selection--multiple .select2-selection__rendered {
    border: 0 !important;
    }
    .create_form .select2-container .select2-selection--multiple{
        border-width:1px !important;
        border-color:#6e6e6e !important;
    }
    .select2-results__options .select2-results__option, .select2-results__options .select2-results__option:hover,.select2-container--default .select2-results__option--highlighted[aria-selected]{
        padding: 6px !important;
        height: unset !important;
        font-size: 13px!important ;
    }
    </style>











    <div class="col-md-12">
<div class="setup-content" id="step-1">
    <div class="row">
        <div class="col-md-6 col-sm-12 mt-4">
            <div class="form-group mg-b-0">
                <label class="form-label">Campaign Name : <span class="text-danger">*</span></label>
                {{-- {!! Form::text('name',null,['class' =>'form-control '.($errors->has('name') ? 'parsley-error' : null),'placeholder'=> 'Enter Campaign Name','id'=>'name' ]) !!} --}}
                <input name="name" type="text" class="form-control" value="{{isset($campaign) ? $campaign->name : ''}}" placeholder='Enter Campaign Name' id="name">
                @error('name')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        @if (request()->get('brand'))
            <div class="col-md-6 col-sm-12 mt-4">
                <div class="form-group mg-b-0">
                    <label class="form-label"> Company : <span class="text-danger">*</span></label>
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
            <div class="col-md-6 col-sm-12 mt-4">
                <div class="form-group mg-b-0">
                    <label class="form-label"> Company : <span class="text-danger">*</span></label>
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
                {!! Form::select('sub_brand_id', subBrands($campaign->brand_id??null, $selected_countries), null, [
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
        <input type="hidden" value="{!! json_encode($campaign->compliments_branches_list??[]) !!}" id="selected_compliment_branches">
        <div class="col-md-6 mt-4 brand_data_append" style="display:none;">
            <div class="form-group mg-b-0">
                <label class="form-label">Branches : <span class="text-danger">*</span></label>
                {!! Form::select('branch_ids[]', branches($campaign->brand_id??null, $campaign->sub_brand_id??null ,$selected_countries), null, [
                    'class' => 'form-control select2 ' . ($errors->has('branch_ids') ? 'parsley-error' : null),
                    'data-show-subtext' => 'true',
                    'data-live-search' => 'true',
                    'id' => 'branch_ids',
                    'multiple',
                ]) !!}
                @error('branch_ids')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="form-group mt-4  col-md-6">
            <label class="form-label"> Preferred Gender: <span class="text-danger">*</span></label>
            {!! Form::select('gender', preferred_gender(), (isset($campaign) ? $campaign->gender: null ), [
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




        <div class="col-md-6 col-sm-12 mt-4">
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

        <div class="col-md-6 mt-4">
            <div class="form-group mg-b-0">
                <label class="form-label">Objective: <span class="text-danger">*</span></label>
                {!! Form::select('objective_id', updatedCampaignObjectivesArray(), null, [
                    'class' => 'form-control select2 ' . ($errors->has('objective_id') ? 'parsley-error' : null),
                    'data-show-subtext' => 'true',
                    'data-live-search' => 'true',
                    'id' => 'objective_id',
                    'data-campaign_type' => $campiegn->campaign_type??null,
                    'placeholder' => 'select object',
                    'style' => 'width:100% !important',
                ]) !!}
                @error('objective_id')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-md-6 mt-4">
            <div class="form-group mg-b-0">
                <label class="form-label">Campaign Type: <span class="text-danger">*</span></label> {{--campaignType()--}}
                {!! Form::select('campaign_type', campaignType($campaign->objective_id??null), null, [
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



        {{-- <div class="col-lg-4 col-md-6 col-sm-12 mt-4" style="display: none">
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
</div> --}}

        <div class="col-md-12 row campaign-dates-container" style="display: none">
            <div class="col-md-6 visit-dates-container row" style="display: none">
                <div class="col-lg-8 col-md-8 col-sm-8 mt-4">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Visit Start Date: <span class="text-danger">*</span></label>
                        {!! Form::date('visit_start_date', null, [
                            'class' => 'form-control visit-dates' . ($errors->has('visit_start_date') ? 'parsley-error' : null),
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
                <div class="col-lg-4 col-md-6 col-sm-4 mt-4">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Time: <span class="text-danger">*</span></label>
                        {!! Form::time('visit_from', $campaign->visit_from??null, [
                            'class' => 'form-control visit-dates' . ($errors->has('visit_from') ? 'parsley-error' : null),
                            'autocomplete' => 'off',
                            'placeholder' => 'Select',
                            'id' => 'visit_from',
                        ]) !!}

                        @error('visit_from')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 visit-dates-container row" style="display: none">
                <div class="col-lg-8 col-md-8 col-sm-8 mt-4">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Visit End Date: <span class="text-danger">*</span></label>
                        {!! Form::date('visit_end_date', null, [
                            'class' => 'form-control visit-dates' . ($errors->has('visit_end_date') ? 'parsley-error' : null),
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
                <div class="col-lg-4 col-md-6 col-sm-4 mt-4">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Time: <span class="text-danger">*</span></label>
                        {!! Form::time('visit_to', $campaign->visit_to??null, [
                            'class' => 'form-control visit-dates' . ($errors->has('visit_to') ? 'parsley-error' : null),
                            'autocomplete' => 'off',
                            'placeholder' => 'Select',
                            'id' => 'visit_to',
                        ]) !!}

                        @error('visit_to')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>
                </div>
            </div>

            <input type="hidden" name="old_visit_start_date" value="{{$campaign->visit_start_date??""}}">
            <input type="hidden" name="old_deliver_start_date" value="{{$campaign->deliver_start_date??""}}">

            <div class="col-md-6 deliver-dates-container row" style="display: none">
                <div class="col-lg-8 col-md-8 col-sm-8 mt-4">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Delivery Start Date: <span class="text-danger">*</span></label>
                        {!! Form::date('deliver_start_date', null, [
                            'class' => 'form-control date-input deliver-dates' . ($errors->has('deliver_start_date') ? 'parsley-error' : null),
                            'autocomplete' => 'off',
                            'placeholder' => 'Select',
                            'id' => 'deliver_start_date',
                            'min' => date('Y-m-d'),
                        ]) !!}
                        @error('deliver_start_date')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-4 mt-4">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Time: <span class="text-danger">*</span></label>
                        {!! Form::time('deliver_from', $campaign->delivery_from??null, [
                            'class' => 'form-control date-input deliver-dates' . ($errors->has('deliver_from') ? 'parsley-error' : null),
                            'autocomplete' => 'off',
                            'placeholder' => 'Select',
                            'id' => 'deliver_from',
                            'min' => date('Y-m-d'),
                        ]) !!}
                        @error('deliver_from')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 deliver-dates-container row" style="display: none">
                <div class="col-lg-8 col-md-8 col-sm-8 mt-4">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Delivery End Date : <span class="text-danger">*</span></label>
                        {!! Form::date('deliver_end_date', null, [
                            'class' => 'form-control date-input  deliver-dates' . ($errors->has('deliver_end_date') ? 'parsley-error' : null),
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
                <div class="col-lg-4 col-md-6 col-sm-4 mt-4">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Time : <span class="text-danger">*</span></label>
                        {!! Form::time('deliver_to', $campaign->delivery_to??null, [
                            'class' => 'form-control date-input  deliver-dates' . ($errors->has('delivery_to') ? 'parsley-error' : null),
                            'autocomplete' => 'off',
                            'placeholder' => 'Select',
                            'id' => 'deliver_to',
                        ]) !!}
                        @error('deliver_to')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-sm-12 mt-4">
            <div class="form-group mg-b-0">
                <label class="form-label">Target Influencers: <span class="text-danger">*</span></label>
                {!! Form::number('target_influencer', $campaign->target??null, [
                    'class' => 'form-control ' . ($errors->has('target') ? 'parsley-error' : null),
                    'placeholder' => 'Enter Total Number Of Target Influencers',
                    'id' => 'target',
                    'min' => '0',
                ]) !!}
                @error('target_influencer')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-md-6 col-sm-12 mt-4">
            <div class="form-group mg-b-0 influencer_per_day">
                <label class="form-label">Daily Influencers :</label>
                {!! Form::number('influencer_per_day', $campaign->influencer_per_day??null, [
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

        <div class="col-md-6 col-sm-12 mt-4">
            <div class="form-group mg-b-0 daily_influencer">
                <label class="form-label">Target Confirmation :</label>
                {!! Form::number('target_confirmation', $campaign->daily_influencer??null, [
                    'class' => 'form-control ' . ($errors->has('target_confirmation') ? 'parsley-error' : null),
                    'placeholder' => 'Enter Number Of Target Confirmation',
                    'id' => 'target_confirmation',
                    'min' => '0',
                ]) !!}
                @error('target_confirmation')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-md-6 col-sm-12 mt-4">
            <div class="form-group mg-b-0 daily_confirmation">
                <label class="form-label"> Daily Confirmation :</label>
                {!! Form::number('daily_confirmation', $campaign->daily_confirmation??null, [
                    'class' => 'form-control ' . ($errors->has('daily_confirmation') ? 'parsley-error' : null),
                    'placeholder' => 'Enter Number Of Daily Confirmation',
                    'id' => 'daily_confirmation',
                    'min' => '0',
                ]) !!}
                @error('daily_confirmation')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

{{--        <div class="col-lg-4 col-md-6 col-sm-12 mt-4">--}}
{{--            <div class="form-group mg-b-0">--}}
{{--                <label class="form-label">Instagram : </label>--}}
{{--                <input name="instagram_username" class="form-control" placeholder='Enter Instagram Username' id="instagram_username"--}}
{{--                       value="">--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="col-lg-4 col-md-6 col-sm-12 mt-4">--}}
{{--            <div class="form-group mg-b-0">--}}
{{--                <label class="form-label">Tiktok : </label>--}}
{{--                <input name="tiktok_username" class="form-control" placeholder='Enter Tiktok Username' id="tiktok_username"--}}
{{--                       value="">--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="col-lg-4 col-md-6 col-sm-12 mt-4">--}}
{{--            <div class="form-group mg-b-0">--}}
{{--                <label class="form-label">Snapchat : </label>--}}
{{--                <input name="snapchat_username" class="form-control" placeholder='Enter Snapchat Username' id="snapchat_username"--}}
{{--                       value="">--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="col-lg-4 col-md-6 col-sm-12 mt-4">--}}
{{--            <div class="form-group mg-b-0">--}}
{{--                <label class="form-label">Facebook : </label>--}}
{{--                <input name="facebook_username" class="form-control" placeholder='Enter Facebook Username' id="facebook_username"--}}
{{--                       value="">--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="col-lg-4 col-md-6 col-sm-12 mt-4">--}}
{{--            <div class="form-group mg-b-0">--}}
{{--                <label class="form-label">Youtube : </label>--}}
{{--                <input name="youtube_username" class="form-control" placeholder='Enter Youtube Username' id="youtube_username"--}}
{{--                       value="">--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="col-12 mt-4" style="display: none">
{{--            <h5><i class="fas fa-link"></i> countries list</h5>--}}
            <hr>
            <div class="row" id="countries_list">

                <div class="col-6 mt-3">
                    <div class="form-group mg-b-0">
                        <label class="form-label">Favourite List : <span class="text-danger">*</span></label>
                        <select class="form-control select2 multiple" id="list_ids_select" data-id-suffix="1"
                                name="list_ids[]" multiple data-selected_ids='@if(isset($campaign) && $campaign && !empty($campaign->list_ids)){!! json_encode($campaign->list_ids) !!}@else[]@endif'>
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <hr>

    <div class="row">
        {{--            <div class="col-md-12">--}}
        {{--                <h1 class=" mb-3 ">Coverage Info</h1>--}}
        {{--            </div>--}}
        {{--            <div class="col-md-6 _input__text">--}}
        {{--                <div class="form-group mg-b-0">--}}
        {{--                    <label class="form-label">--}}
        {{--                        Min story <span class="text-danger">*</span>--}}
        {{--                        {!! Form::number('min_story',( isset($campaign)? $campaign->min_story : ''), [--}}
        {{--                            'class' => 'form-control ' . ($errors->has('min_story') ? 'parsley-error' : null),--}}
        {{--                            'placeholder' => 'Enter Total Minimum Story',--}}
        {{--                            'id' => 'min_story',--}}
        {{--                            'min' => '0',--}}
        {{--                        ]) !!}--}}
        {{--                    </label>--}}
        {{--                    @error('min_story')--}}
        {{--                    <span class="error-msg-input">{{ $message }}</span>--}}
        {{--                    @enderror--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--            --}}{{-- createMode --}}
        {{--            @if(!isset($campaign))--}}
        {{--                @include('admin.dashboard.campaign.coverageForm.create')--}}
        {{--            @else--}}
        {{--                @include('admin.dashboard.campaign.coverageForm.edit')--}}
        {{--            @endif--}}


        <div class="col-md-12 row" id="all_compliment_inputs_container">
        <div class="col-md-6 mt-4">
            <div class="form-group mg-b-0">
                <label class="form-label">Compliment Type: </label> {{--campaignType()--}}
                {!! Form::select('compliment_type', complimentArray(), null, [
                    'class' => 'form-control select2 ' . ($errors->has('compliment_type') ? 'parsley-error' : null),
                    'data-show-subtext' => 'true',
                    'data-live-search' => 'true',
                    'id' => 'compliment_type',
                    'placeholder' => 'select type',
                    'style' => 'width:100% !important',
                ]) !!}
                @error('compliment_type')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-md-6 mt-4" style="display:none;" id="compliment_branches_container">
            <div class="form-group mg-b-0">
                <label class="form-label">Branches : <span class="text-danger">*</span></label>
                {!! Form::select('compliment_branches[]', (branches($campaign->brand_id??null, $campaign->sub_brand_id??null ,$selected_countries)), ($campaign->compliments_branches_list??[]), [
                    'class' => 'form-control select2 ' . ($errors->has('compliment_branches') ? 'parsley-error' : null),
                    'data-show-subtext' => 'true',
                    'data-live-search' => 'true',
                    'id' => 'compliment_branches',
                    'multiple',
                ]) !!}
                @error('compliment_branches')
                <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        @php
            $currenciesList = currenciesList();
        @endphp

        <div class="container-fluid row" id="compliment_inputs">
            <div class="col-md-6 row p-3" id="voucher_inputs">
                <h4 class="mt-2"><i class="fa fa-list"></i> Voucher</h4>
                <div class="col-md-12 mt-2 row">
                    <div class="col-md-7">
                        <label class="form-label">Voucher Expired Date: <span class="text-danger">*</span></label>
                        {!! Form::date('voucher_expired_date', $campaignCompliment->voucher_expired_date??null, [
                            'class' => 'form-control' . ($errors->has('voucher_expired_date') ? 'parsley-error' : null),
                            'autocomplete' => 'off',
                            'id' => 'voucher_expired_date',
                            'min' => date('Y-m-d'),
                        ]) !!}

                        @error('voucher_expired_date')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">Time: <span class="text-danger">*</span></label>
                        {!! Form::time('voucher_expired_time', $campaignCompliment->voucher_expired_time??null, [
                            'class' => 'form-control' . ($errors->has('voucher_expired_time') ? 'parsley-error' : null),
                            'autocomplete' => 'off',
                            'id' => 'voucher_expired_time',
                        ]) !!}

                        @error('voucher_expired_time')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 row mt-2">
                    <div class="col-md-7">
                        <label class="form-label">Voucher Amount: <span class="text-danger">*</span></label>
                        {!! Form::number('voucher_amount', $campaignCompliment->voucher_amount??null, [
                            'class' => 'form-control' . ($errors->has('voucher_amount') ? 'parsley-error' : null),
                            'autocomplete' => 'off',
                            'placeholder' => 'Voucher Amount',
                            'step' => '0.01',
                            'id' => 'voucher_amount',
                        ]) !!}


                        @error('voucher_amount')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">Currency: <span class="text-danger">*</span></label>
                        {!! Form::select('voucher_amount_currency', $currenciesList, $campaignCompliment->voucher_amount_currency??null, [
                            'class' => 'form-control select2' . ($errors->has('voucher_amount_currency') ? 'parsley-error' : null),
                            'id' => 'voucher_amount_currency',
                            'placeholder' => 'Select',
                        ]) !!}

                        @error('voucher_amount_currency')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>
                </div>
            </div> <!-- end voucher inputs -->
            <div class="col-md-6 row p-3" id="gift_inputs">
                <h4 class="mt-2"><i class="fa fa-gift"></i> Gift: </h4>
                <div class="col-md-12 mt-2 row">
                    <label class="form-label">Gift Image:  <span class="text-danger">*</span></label>
                    @php
                        $giftImages = (isset($campaignCompliment->gift_image) && is_array($campaignCompliment->gift_image))?$campaignCompliment->gift_image:[];
                $newGiftImages = [];
                foreach ($giftImages as $giftRow){
                    if(isset($giftRow['id'])){
                       $newGiftImages[$giftRow['id']] = $giftRow['name'];
                    }
                }
                    @endphp
                    @include('admin.dashboard.layouts.includes.upload-file-input', ['inputName' => 'gift_image[]', 'inputId' => 'gift_image', 'oldValues' => $newGiftImages, 'uploadPath' => url('photos/campaign').'/'])

                    {{--                        <div class="col-md-6">--}}
                    {{--                            <input type="hidden" name="gift_image" value="{{$campaignCompliment->gift_image??null}}">--}}
                    {{--                            {!! Form::file('gift_image', null, [--}}
                    {{--                                'class' => 'form-control' . ($errors->has('gift_image') ? 'parsley-error' : null),--}}
                    {{--                                 'accept' => 'image/*',--}}
                    {{--                                'id' => 'gift_image',--}}
                    {{--                            ]) !!}--}}

                    {{--                            @error('gift_image')--}}
                    {{--                            <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">--}}
                    {{--                                <li class="parsley-required">{{ $message }}</li>--}}
                    {{--                            </ul>--}}
                    {{--                            @enderror--}}
                    {{--                        </div>--}}

                </div>
                <div class="col-md-12 row mt-2">
                    <div class="col-md-7">
                        <label class="form-label">Gift Amount: <span class="text-danger">*</span></label>
                        {!! Form::number('gift_amount', $campaignCompliment->gift_amount??null, [
                            'class' => 'form-control' . ($errors->has('gift_amount') ? 'parsley-error' : null),
                            'autocomplete' => 'off',
                            'placeholder' => 'Gift Amount',
                            'step' => '0.01',
                            'id' => 'gift_amount',
                        ]) !!}


                        @error('gift_amount')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">Currency: <span class="text-danger">*</span></label>
                        {!! Form::select('gift_amount_currency', $currenciesList, $campaignCompliment->gift_amount_currency??null, [
                            'class' => 'form-control select2' . ($errors->has('gift_amount_currency') ? 'parsley-error' : null),
                            'id' => 'gift_amount_currency',
                            'placeholder' => 'Select',
                        ]) !!}

                        @error('gift_amount_currency')
                        <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>
                </div>


                <div class="col-md-12">
                    <label class="form-label">Gift Description: </label>
                    {!! Form::textarea('gift_description', $campaignCompliment->gift_description??null, [
                        'class' => 'form-control' . ($errors->has('gift_description') ? 'parsley-error' : null),
                        'placeholder' => 'Description',
                        'rows' => '2',
                        'id' => 'gift_image',
                    ]) !!}

                    @error('gift_description')
                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                        <li class="parsley-required">{{ $message }}</li>
                    </ul>
                    @enderror
                </div>
            </div> <!-- end voucher inputs -->
            <br/>
        </div>
        </div> <!-- End all_compliment_inputs_container -->
    </div>

    <div class="save w-100 pb-4">
        <button type="button" class="btn btn-primary next-btn-step btn-lg pull-right grand-button-step"
                data-step="1">Next</button>
    </div>
</div>
</div>
</div>