<div class="col-12 mt-4">
    <div class=" setup-content" id="step-2">
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


            @if (isset($secrets))

                <div class="col-md-12 mt-4 secret-container" id="brand-secrets">
                    <h5 class="mt-3 mb-3">campain secrets</h5>
                    <hr>
                    {{-- <button class="btn btn-warning float-right add-secret" type="button">Add secret</button> --}}
                    <div class="clearfix"></div>

                    {{-- @if (isset($secrets)) --}}

                    @forelse($secrets as $secret)
                        <div class="row secrets"
                             data-county-id="{{ @$secret->campaignCountry->country_id }}">
                            <div class="col-8">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">{{ @$secret->campaignCountry->country->name }}
                                        secret: <span class="text-danger">*</span></label>
                                    {!! Form::text('secret[' . @$secret->campaignCountry->country_id . ']', $secret->secret, [
                                        'data-id' => $secret->campaignCountry->country_id,
                                        'class' => 'form-control secret ' . ($errors->has('secret') ? 'parsley-error' : null),
                                        'placeholder' => 'Enter secret',
                                        'id' => 'secret_' . $secret->campaignCountry->country_id,
                                    ]) !!}

                                    @error('secret')
                                    <ul class="parsley-errors-list filled  text-danger" id="parsley-id-11">
                                        <li class="parsley-required">{{ $message }}</li>
                                    </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mt-4">
                                <div class="form-group">
                                    <button class="btn btn-success generate-secret" type="button">generate
                                        secret</button>
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
                                                style="display: none"><i class="icon-trash-2"></i></button>
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

            <div class="col-md-4 mt-4">
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

            <div class="col-md-4 mt-4" style="display:none;" id="compliment_branches_container">
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
                        @endphp
                        @include('admin.dashboard.layouts.includes.upload-file-input', ['inputName' => 'gift_image[]', 'inputId' => 'gift_image', 'oldValues' => implode('||', $giftImages), 'uploadPath' => url('uploads/giftImages').'/'])

{{--                        <div class="col-md-4">--}}
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
                        <label class="form-label">Gift Description: <span class="text-danger">*</span></label>
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
        </div>
        <button type="button" class="btn btn-primary previous-btn-step btn-lg pull-right" data-step="2">Previous</button>
        <button type="button" class="btn btn-primary next-btn-step btn-lg pull-right" data-step="2">Next</button>

    </div>
</div>
