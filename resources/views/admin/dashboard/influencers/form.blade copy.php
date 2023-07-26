<div class="col-12 social_media_card">
                            <h5 class="mt-3"><i class="fas fa-link"></i> General</h5>
                            <hr>
                            <div class="row">
                                <div class="col-xl-4 col-md-6 col-sm-12 ">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label">Name <span class="text-danger">*</span> </label>
                                            <input class="form-control  @if ($errors->has('name')) parsley-error @endif " value="{{ isset($influencer) ? old('name',$influencer->name) : old('name') }}" name="name" placeholder="Enter Name" type="text">
                                        @error('name')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-xl-4  col-md-6 col-xs-12">
                                    <div class="form-group ">
									     <label class="form-label" >Instagram <span class="text-danger">*</span></label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1" style=" border: none; background: #202020; "><i style="color: #fff;" class="fab fa-instagram"></i></span>
                                        <input onkeyup="this.value=removeSpaces(this.value);" type="text" name="insta_uname" placeholder="Enter Instagram Username" class="form-control @if ($errors->has('insta_uname')) parsley-error @endif" value="{{ isset($influencer) ? old('name',$influencer->insta_uname) :  old('insta_uname') }}">
                                    </div>
                                    @error('insta_uname')
                                     <span class="error-msg-input">{{ $message }}</span>
                                    @enderror
                                </div> </div> --}}
                                <div class="col-xl-4 col-md-6 col-xs-12">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label" >Image:</label>
                                        <div class="custom-file">
                                            <input type="file" value="{{ old('fileReader') }}" name="image" class="custom-file-input @if ($errors->has('image')) parsley-error @endif" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Select file</label>
                                        </div>
                                        @error('image')
										  <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-xl-4 col-md-6 col-xs-12">
                                    <div class="form-group">
                                           <label class="form-label">Country <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @if ($errors->has('country_id')) parsley-error @endif" id="country_id" name="country_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select<">
                                                @if (empty(old('country_id')))
                                                <option disabled selected> Select</option>
                                                @endif
                                                @foreach ($all_countries_data as $country)
                                                <option value="{{ $country->id }}" {{ isset($influencer) && old('country_id',$influencer->country_id) ? "selected" : (old('country_id') == $country->id ? 'selected' : '') }}>
                                                    {{ $country->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        @error('country_id')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4  col-md-6 col-xs-12 state">
                                    <div class="form-group">
									<label class="form-label">Government</label>
                                             <select class="form-control select2 @if ($errors->has('state_id')) parsley-error @endif" !@isset($influencer) disabled @endisset id="state_id" name="state_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
													@if(isset($influencer->country))
													@if(!empty($influencer->country->states()))
														@foreach($influencer->country->states()->get() as $state)
															<option value="{{$state->id}}" @if($influencer->state_id == $state->id ) selected @endif>{{$state->name}}</option>
														@endforeach
													@endif
												@endif
											</select>
                                        </label>
                                        @error('state_id')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 col-xs-12 city">
                                    <div class="form-group">
									     <label class="form-label">City</label>
                                            <select class="form-control select2 @if ($errors->has('city_id')) parsley-error @endif" !@isset($influencer) disabled @endisset id="city_id" name="city_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
											@isset($influencer->country)
												@foreach($influencer->country->cities()->get() as $city)
													<option value="{{$city->id}}" @if($influencer->city_id == $city->id || old('city_id') ==$city->id ) selected="selected" @endif>{{$city->name}}</option>
												@endforeach
											@endisset
										</select>
                                        @error('city_id')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


								<div class="col-xl-4  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                            <select class="form-control select2  @if ($errors->has('nationality')) parsley-error @endif" id="nationality" name="nationality" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" >
                                                @foreach ($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}" {{ isset($influencer) && old('nationality',$influencer->nationality) == $nationality->id ? 'selected' : (old('nationality') == $nationality->id ? 'selected' : '') }}>
                                                    {{ $nationality->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        @error('nationality')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

								<div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Gender: <span class="text-danger">*</span></label>
										<select id="influencer_gender" class="form-control select2 @if ($errors->has('gender')) parsley-error @endif" value="{{ old('gender') }}" name="gender" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
											<option label="Select" disabled selected></option>
											<option value=1 {{ isset($influencer) && $influencer->gender == 1 ? 'selected' : (old('gender') == 1 ? 'selected' : '' )}}>Male</option>
											<option value=0 {{ isset($influencer) && $influencer->gender == 0 ? 'selected' : (old('gender') == '0' ? 'selected' : '') }}>Female</option>
										</select>
										@error('gender')
										<span class="error-msg-input">{{ $message }}</span>
										@enderror
									</div>
								</div>


								<div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Date Of Birth</label>
										<input class="form-control @if ($errors->has('date_of_birth')) parsley-error @endif" value="{{ isset($influencer) ? old('date_of_birth',$influencer->date_of_birth?->format('Y-m-d')) : old('date_of_birth') }}" name="date_of_birth" placeholder="Enter Date OF Birth" type="date" max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
										@error('date_of_birth')
										<span class="error-msg-input">{{ $message }}</span>
										@enderror
									</div>
								</div>

                                <div class="col-xl-4  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Main Phone Number: <span class="text-danger">*</span></label>
                                                <div class="input-group-append">
														<select class="input-group-text country_code select2" name="main_phone_code" data-placeholder="Code" style="width:200px;">
															<option></option>
															@foreach ($all_countries_data as $country)
															<option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}" {{ isset($influencer) && $influencer->user->code ==$country->phonecode ? 'selected' : (!empty(old('main_phone_code')) && old('main_phone_code') == $country->phonecode ? 'selected' : '' )}}>
																{{ $country->phonecode }}
															</option>
															@endforeach
														</select>
                                                    <input type="number" style="width:200%;margin-top:3px;" class="form-control @if ($errors->has('main_phone')) parsley-error @endif" value="{{ isset($influencer) ? old('main_phone',$influencer->user->phone) : old('main_phone')  }}" name="main_phone" placeholder="Enter Main Phone Number"  onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109">

												</div>
                                        @error('main_phone_code')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                        @error('main_phone')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-xl-4 col-md-4 col-sm-4 col-12 main-toggle-group-demo" style="top:20px;">
                                    <div class="form-group">
                                        <div class="switch_parent">
                                            <input type="checkbox" id="switch" class="switch_toggle togBtn" @if(isset($influencer) && !empty($influencer->user->phone) && $influencer->whats_number === $influencer->user->phone) checked @endif>
                                            <label class="switch" for="switch" title="inactive"></label><span style="color:#A27929;margin:2px 0px 0px 3px;">whatsapp is the same as phone</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 col-xs-12" id="whatsappSection">
                                    <div class="form-group">
                                        <label class="form-label">WhatsApp Phone Number: <span class="text-danger">*</span></label>
                                                <div class="input-group-prepend">
                                                    <select class="input-group-text country_code select2" name="whatsapp_code" data-placeholder="Code" style="width:200px;">
                                                        <option></option>
                                                        @foreach ($countries_active as $country)
                                                        <option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}" {{ isset($influencer) && $influencer->code_whats ==$country->phonecode ? 'selected' : (!empty(old('whatsapp_code')) && old('whatsapp_code') == $country->phonecode ? 'selected' : '' )}}>
                                                            {{ $country->phonecode }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <input style="width:200%;margin-top:3px;"  class="form-control phoneInput @if ($errors->has('whats_number')) parsley-error @endif" value="{{ isset($influencer) ? old('whats_number',$influencer->whats_number) : old('whats_number') }}" name="whats_number" placeholder="Enter WhatsApp Phone Number" type="number">
                                                 </div>
													@error('whats_number')
													<span class="error-msg-input">{{ $message }}</span>
                                                    @enderror
                                                    @error('whatsapp_code')
													<span class="error-msg-input">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>



                   </div>




    </div>
<hr>

<div class="col-12 social_media_card">
    <h5 class="mt-3"><i class="fas fa-link"></i> Classification</h5>
    <div class="row">
        @inject('allStatus', 'App\Models\InfluencerClassification')
        @php
        $sta = $allStatus->whereStatus('classification')->get();
        @endphp
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group multiple_select_classification">
			<label class="form-label">Classification</label>
                <select name="classification_ids[]" multiselect-max-items="5" id="chkveg" multiple="multiple">
                    @foreach ($sta as $stat)
                    <option value="{{ $stat->id }}" {{isset($influencer) && !empty($influencer->classification_ids) && in_array($stat->id,$influencer->classification_ids) ? 'selected' : ''}}>{{ $stat->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>


		<div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
			<div class="form-group">
				<label class="form-label">Category:</label>
				<select class="form-control select2  @if ($errors->has('category_ids')) parsley-error @endif" id="category_id" name="category_ids[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" multiple>

					@foreach ($categories as $category)
					<option value="{{ $category->id }}" {{ isset($influencer) && !empty($influencer->category_ids) && in_array($category->id,$influencer->category_ids) ? 'selected' : '' }}>{{ $category->name}}
					</option>
					@endforeach
				</select>
				@error('category_ids')
				<span class="error-msg-input">{{ $message }}</span>
				@enderror
			</div>
		</div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Interests</label>
                <select class="form-control select2 @if ($errors->has('interest')) parsley-error @endif" multiple name="interest[]" id="interest" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
                    @foreach ($interests as $interest)
                    <option value={{ $interest->id }} {{ isset($influencer) && !empty($influencer->interest) && in_array($interest->id,$influencer->interest) ? 'selected' : '' }}>
                        {{ $interest->interest}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

		<div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Job:</label>
                <select class="form-control  @if ($errors->has('job')) parsley-error @endif" id="job" name="job" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
                    @if (empty(old('job')))
                    <option disabled selected> Select</option>
                    @endif
                    @foreach ($jobs as $job)
                    <option value="{{ $job->id }}" {{ isset($influencer) && $influencer->job == $job->id ? 'selected' : (old('job') == $job->id ? 'selected' : '' ) }}>{{ $job->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Lifestyle:</label>
                <select class="form-control  @if($errors->has('ethink_category'))  parsley-error @endif" id="ethink_category" name="ethink_category" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                    @if(empty( old('ethink_category')))
                    <option disabled selected> Select</option>
                    @endif
                    @foreach($staticData['ethinkCategory'] as $key=>$ethink)
                    <option value="{{$ethink['id']}}" {{isset($influencer) && $influencer->ethink_category == $ethink['id'] ? "selected" : ( old('ethink_category')==$ethink['id']? "selected":"")}}>{{$ethink['title']}}</option>
                    @endforeach
                </select>
            </div>
        </div>


<div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
        <label class="form-label">Languages: <span class="text-danger">*</span></label>
        <select class="form-control select2 @if ($errors->has('lang')) parsley-error @endif" multiple id="lang" name="lang[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
            @foreach ($languages as $lang)

            <option value={{ $lang->id }} {{ isset($influencer) && !empty($influencer->lang) && in_array($lang->id,$influencer->lang) ? 'selected' : (collect(old('lang'))->contains($lang->id) ? 'selected' : '') }}>
                {{ $lang->name }}
            </option>
            @endforeach
        </select>
        @error('lang')
		<span class="error-msg-input">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
    <div class="form-group">
        <label class="form-label">Account Type:</label>
        <select class="form-control select2 @if ($errors->has('account_type')) parsley-error @endif" id="account_type" name="account_type" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
            @if (empty(old('account_type')))
            <option disabled selected> Select</option>
            @endif
            @foreach ($staticData['accountType'] as $key => $account_type)
            <option value="{{ $account_type['id'] }}" {{ isset($influencer) && $account_type['id']==$influencer->account_type ? 'selected' : (old('account_type') ==  $account_type['id'] ? 'selected' : '' )}}>
                {{ $account_type['title'] }}
            </option>
            @endforeach
        </select>
        @error('account_type')
		<span class="error-msg-input">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
    <div class="form-group">
        <label class="form-label">Citizenship:</label>
        <select class="form-control select2 @if ($errors->has('citizen_status')) parsley-error @endif" id="citizen_status" name="citizen_status" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
            @if (empty(old('citizen_status')))
            <option disabled selected> Select</option>
            @endif
            @foreach ($staticData['citizenStatus'] as $key => $citizen_status)
            <option value="{{ $citizen_status['id'] }}" {{ isset($influencer) && $citizen_status['id'] ==$influencer->citizen_status ? "selected" : (old('citizen_status') == $citizen_status['id'] ? 'selected' : '') }}>
                {{ $citizen_status['title'] }}
            </option>
            @endforeach
        </select>
        @error('citizen_status')
	      <span class="error-msg-input">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
        <label class="form-label">Coverage Channels: </label>
        <select class="form-control select2 @if ($errors->has('coverage_channel')) parsley-error @endif" id="channel" name="channel_ids[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" multiple>
            @foreach($channels as $channel)
            <option value="{{ $channel->id }}" {{ isset($influencer) &&!empty($influencer->coverage_channel) && in_array($channel->id,$influencer->coverage_channel) ? 'selected' : '' }}>{{ $channel->title }}</option>
            @endforeach
        </select>
        @error('coverage_channel')
		<span class="error-msg-input">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
		<div class="form-group">
            <label class="form-label">Website: </label>
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color: #fff;" class="fas fa-globe"></i></span>
                <input class="form-control @if ($errors->has('website_uname')) parsley-error @endif" value="{{ isset($influencer) ? $influencer->website_uname  : old('website_uname') }}" name="website_uname" placeholder="Enter Website URL" type="url">
            </div>
				@error('website_uname')
				<span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>


        </div>

        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Has Voucher: </label>
                    <div class="input-group-prepend">
                    <input class="form-control @if ($errors->has('has_voucher')) parsley-error @endif" name="has_voucher" placeholder="Enter voucher " type="number">
                </div>
                    @error('has_voucher')
                    <span class="error-msg-input">{{ $message }}</span>
                    @enderror
                </div>


            </div>
        <div class="col-xl-4  col-md-6 col-xs-12 state">
            <div class="form-group">
            <label class="form-label">Attitude <span class="text-danger">*</span></label>
                     <select class="form-control select2 parsley-error"  id="attitude_id" name="attitude_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
                                @foreach($attitude as $attit)
                                    <option value="{{$attit['id']}}" >{{$attit['name']}}</option>
                                @endforeach
                    </select>

                @error('state_id')
                <span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>
        </div>

<hr>
<div class="clearfix"></div>


<div class="col-xl-6 col-lg-6  col-md-6 col-xs-12">
							<div class="form-group">
								<label class="form-label" >Address [English]</label>
										<textarea class="form-control @if ($errors->has('address')) parsley-error @endif" name="address" rows="4" value="" placeholder="Enter Address" type="text">
										{{{isset($influencer) ?  old('address',$influencer->address) : old('address') }}}
										</textarea>
								@error('address')
								<span class="error-msg-input">{{ $message }}</span>
								@enderror
							</div>
						</div>


						<div class="col-xl-6 col-lg-6  col-md-6 col-xs-12">
							<div class="form-group">
								<label class="form-label" >Address [Arabic]</label>
										<textarea class="form-control @if ($errors->has('address')) parsley-error @endif" name="address_ar" rows="4" value="" placeholder="Enter Address" type="text">
											{{{isset($influencer) ?  old('address_ar',$influencer->address_ar) : old('address_ar') }}}
										</textarea>
								@error('address')
								<span class="error-msg-input">{{ $message }}</span>
								@enderror
							</div>
						</div>
                                    <input type="hidden" name="influencer_id">
                                    <div class="clearfix"></div>
									<div class="col-xl-12 col-lg-6 col-md-4 col-sm-4 col-12">
										<div class="form-group">
											<label class="form-label">Phone Number: </label>
											<div ><button type="button" id="add_phone_input" class="add_phone_input btn seeMore hvr-sweep-to-right"><i class="fas fa-plus"></i>Add New Phone</button></div>
											<div class="allPhones">
											@if(isset($influencer) && $influencer->InfluencerPhones)
                                                @foreach($influencer->InfluencerPhones as $key=>$phones)
                                                    @if(!is_null($phones))
												<div class="inputs " style="display: flex;width: 60%;align-items: center;gap: 25px;margin-top: -7px;max-width: 100%;width: 100% !important;" min="0">
													<div class="input-group-prepend">
															<select class="input-group-tex select2" name="phone_type[]" data-placeholder="Code" style="width:200px;margin-top:3px;">
																<option value="" disabled selected>Select</option>
																@foreach ($staticData['typePhone'] as $key => $typephone)
																<option value="{{$typephone['id']}}" {{$typephone['id'] == $phones->type ? 'selected': '' }}>{{$typephone['title']}}</option>
																@endforeach
															</select>
														<select class="input-group-text country_code select2" name="phone_code[]" data-placeholder="Code" style="width:200px;">
															<option></option>
															@foreach ($countries_active as $country)
															<option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}" {{($country->phonecode  == $phones->code)  ? 'selected' : ''}}>
																{{ $country->phonecode }}
															</option>
															@endforeach
														</select>

													<input type="text" value="{{$phones->phone}}" placeholder="Enter Phone Number" style="width:200%;margin-top:3px;" type="number" min="0" name="phone[]" class=" phoneInput form-control   @if ($errors->has('phone.*')) parsley-success @endif">
													</div>
													<div style="margin-top:10px;">
													<a href="javascript:void(0)" onClick="deleteBranch(this)" class="deleterr btn btn-danger mb-2" ><i class="fas fa-trash-alt"></i></a>
													</div>
											</div>
											@endif
                                                @endforeach

											@endif



										</div>
										@error('phone_code')
										<span class="error-msg-input">{{ $message }}</span>
										@enderror

										@error('phone_type')
											<span class="error-msg-input">{{ $message }}</span>
										@enderror
										@error('phone.*')
										<span class="error-msg-input">{{ $message }}</span>
										@enderror
									</div>




									<!--  Social Media -->
<div class="col-12 social_media_card">
    <h5 class="mt-3"><i class="fas fa-link"></i> Social Media</h5>
    <div class="row allSocails">



@if(!isset($influencer))
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-6 ">
            <div class="form-group">
                    <label class="form-label">Social Media <span class="text-danger">*</span></label>
                    <div class="form formgroupsocialMedia" style=" display: flex; align-items: stretch; " id="formgroupsocialMedia">
                        <select name="platforms[]" class="form-control parsley-error social_media selectappend"  id="social_media" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
                            <option value="" selected disabled>Select</option>

                        </select>
                        @error('social_media')
                        <span class="error-msg-input">{{ $message }}</span>
                        @enderror

                        <input type="text" style=" flex: 1 1 auto; min-width: 70%; background: aliceblue;" name="socials[]"   class="form-control inputsocial"    >
                    </div>

                </div>
            </div>

            @elseif(isset($influencer) && count($socialMedia) > 0)
            {{-- //edit mode --}}
            @php
                $socailMe = ['twitter','insta','snapchat','facebook', 'tiktok'];
            @endphp
            @foreach ($socialMedia  as $key => $socal)
            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-6 ">
                <div class="form-group">
                        <label class="form-label">Social Media <span class="text-danger">*</span></label>
                        <div class="form formgroupsocialMedia" style=" display: flex; align-items: stretch; " id="formgroupsocialMedia">
                            <select name="platforms[]" class="form-control parsley-error social_media selectappend"  id="social_media"  data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
                                @foreach ($socailMe as $keyele=> $eled)
                                <option value="{{$keyele}}"  {{$eled == $key ? 'selected' : false}} >{{$eled}}</option>
                                @endforeach
                            </select>
                            @error('platforms.*')
                            <span class="error-msg-input">{{ $message }}</span>
                            @enderror
                            <input type="text" style=" flex: 1 1 auto; min-width: 70%; background: aliceblue; " value=""   class="form-control inputsocial"    >
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        @if(!isset($influencer))
        <div style="margin-top:10px;"><button type="button" id="add_social_input" class="add_social_input btn seeMore hvr-sweep-to-right"><i class="fas fa-plus"></i>Add</button></div>
        @else
        <div style="margin-top:10px;"><button type="button" id="add_social_input" class="add_social_input btn seeMore hvr-sweep-to-right"><i class="fas fa-plus"></i>Add</button></div>
         @endif
        <hr>
<div class="col-12 social_status_card">
    <h5><i class="fas fa-link"></i> Marital Status</h5>
    <div class="row">
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">

            <div class="form-group">

                @foreach ($socialStatus as $social)
                <div class="form-check-inline">
                    <label class="form-check-label socialRadioType" data-type="{{ $social['id'] }}">
                        <input type="radio" class="form-check-input" name="marital_status" @if(isset($influencer) && old('marital_status', $influencer->marital_status) == $social['id']) checked @elseif (!empty(old('marital_status')) && old('marital_status')==$social['id']) checked @endif value="{{ $social['id'] }}" onchange="socialType('{{ $social['id'] }}')">
                        {{ $social['name'] }}
                    </label>
                </div>
                @endforeach
                @error('marital_status')
				<span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12" @if ( (isset($influencer) && $influencer->social_type == 1) || (isset($influencer) && empty($influencer->children_num)) || !old('children_num')) style="display: none;" @endif>
            <label for="lang">Children Number</label>
            <input class="form-control" type="number" id="children_num" value="{{ isset($influencer) ? old('children_num', $influencer->children_num) : old('children_num') }}" onkeypress="diableChars(event)" name="children_num" min="1" max="15" style="width: 180px">
            @error('children_num')
            <span class="error-msg-input">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-lg-12 col-md-12  col-xs-12" id="childrenContainer">
		@if(isset($influencer) && !empty($influencer->ChildrenInfluencer))
		@foreach($influencer->ChildrenInfluencer as $key => $children)
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="child_name" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Children Name </label>
                                    <input type="text" name="child_name[]" value="{{$children['child_name']}}" placeholder="Children Name " class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label for="DOB">Children Date Of Birth</label>
                                    <input type="date" name="child_dob[]" value="{{@$children['child_dob']}}" class="form-control"  max="{{\Carbon\Carbon::today()->format('Y-m-d')}}" >
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Children Gender</label>
                                    <select class="input-group-text childrenGender select2" placeholder="Children Type" name="child_gender[]">
                                        <option value="male" @if(isset($children['gender']) && $children['gender'] == "male") selected @endif>Male</option>
                                        <option value="female"  @if(isset($children['gender']) &&  $children['gender'] == "female") selected @endif >Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

</div>
</div>
<hr>


<div class="col-12 social_media_card">
    <h5><i class="fas fa-link"></i> Authentication</h5>
    <div class="row">
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Username: <span class="text-danger">*</span></label>
                <input onkeyup="this.value=removeSpaces(this.value);" class="form-control @if ($errors->has('user_name')) parsley-error @endif" value="{{ isset($influencer) ? old('user_name',$influencer->user->user_name) : old('user_name') }}" name="user_name" placeholder="Enter Username" type="text">
                @error('user_name')
				<span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Email: <span class="text-danger">*</span></label>
                <input onkeyup="this.value=removeSpaces(this.value);" class="form-control  @if ($errors->has('email')) parsley-error @endif" value="{{ isset($influencer) ? old('user_name',$influencer->user->email) : old('email') }}" name="email" placeholder="Enter Email" type="text">
                @error('email')
				<span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Password: <span class="text-danger">*</span></label>
                <i class="fas fa-eye"></i>
                <input class="form-control @if ($errors->has('password')) parsley-error @endif" value="{{  old('password') }}" name="password" placeholder="Enter Password" type="password">
                @error('password')
				<span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Status: <span class="text-danger">*</span></label>
                <select class="form-control select2 @if ($errors->has('active')) parsley-error @endif" id="status_infl" value="{{ old('active') }}" name="active" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                    <option value=""> Select</option>
                    @foreach ($statInflue as $social_class)
                    <option value="{{ $social_class['id'] }}" {{isset($influencer) && $influencer->active ==  $social_class['id'] ? 'selected' : ''}}>{{ $social_class['name'] }} </option>
                    @endforeach

                </select>
                @error('active')
				<span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-xl-4  col-md-6 col-xs-12 licence_check">
            <span style="font-size: 12px;color:#fff"> Check <span style="color:red">*</span> </span>
            <div class="form-check">
                <input type="checkbox" name="licence" class="form-contr ol @if ($errors->has('has_voucher')) parsley-error @endif" >
                <label class="form-check-label" for="defaultCheck1">
                licence
                </label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="v_by_g" class="form-contr ol @if ($errors->has('v_by_g')) parsley-error @endif" value="1">
                <label class="form-check-label" for="defaultCheck1">
                v_by_g
                </label>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12 databindOnlyDelivery" @if(isset($influencer) && $influencer->active == "7") style="display:block;" @else style="display:none;"  @endif>
            <div class="form-group">
                <label class="form-label">Country Visit: <span class="text-danger">*</span></label>
                <select class="form-control  @if ($errors->has('country_visited_outofcountry')) parsley-error @endif" id="country_visited_outofcountry" name="country_visited_outofcountry" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select<">
                    @if (empty(old('country_visited_outofcountry')))
                    <option disabled selected> Select</option>
                    @endif
                    @foreach ($countries_active as $country)
                    <option value="{{ $country->id }}" {{ isset($influencer) && $influencer->country_visited_outofcountry == $country_id ? "selected" : (old('country_visited_outofcountry') == $country->id ? 'selected' : '') }}>
                        {{ $country->name }}
                    </option>
                    @endforeach
                </select>
                @error('country_visited_outofcountry')
				<span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12 databindOnlyDelivery" @if(isset($influencer) && $influencer->active == "7") style="display:block;" @else style="display:none;" @endif>

            <div class="form-group">
                <label class="form-label">Returned Date: </label>
                <input class="form-control @if ($errors->has('influencer_return_date')) parsley-error @endif" value="{{ isset($influencer)  && !empty($influencer->influencer_return_date) ? $influencer->influencer_return_date->format('Y-m-d') :  old('influencer_return_date') }}" name="influencer_return_date" placeholder="Enter Date" type="date" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                @error('influencer_return_date')
				<span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Account Expiration Date: </label>
                <input class="form-control @if ($errors->has('expirations_date')) parsley-error @endif" value="{{ isset($influencer) ? old('expirations_date',$influencer->expirations_date) : old('expirations_date') }}" name="expirations_date" placeholder="Enter Date" type="date" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                @error('expirations_date')
				<span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
<!--  Social Status -->



</div>
</div>
<div class="col-12 text-right"><button class="btn btn-primary pd-x-20 mg-t-10" style="width: 150px" type="submit"> <i class="far fa-save"></i> Save </button></div>
</div>
